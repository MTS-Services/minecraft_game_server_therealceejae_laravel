<?php

namespace Azuriom\Plugin\ServerListing\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Azuriom\Plugin\ServerListing\Models\ServerCountry;
use Azuriom\Plugin\ServerListing\Models\ServerTag;
use Azuriom\Plugin\ServerListing\Models\Tag;
use Azuriom\Plugin\ServerListing\Models\ServerBid;
use Azuriom\Plugin\ServerListing\Requests\ServerRequest;
use Azuriom\Plugin\ServerListing\Services\ServerStatusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class ServerListingController extends Controller
{
    protected ServerStatusService $serverStatusService;

    public function __construct(ServerStatusService $serverStatusService)
    {
        $this->serverStatusService = $serverStatusService;
    }

    public function details(string $slug)
    {
        $serverDetail = ServerListing::with(['user', 'serverTags', 'country', 'favorites'])->withCount('favorites')->where('slug', $slug)->firstOrFail();
        return view('server-listing::details', compact('serverDetail'));
    }

    public function submission()
    {
        $tags = Tag::orderBy('name')->get();
        return view('server-listing::user.server_submission', compact('tags'));
    }

    public function store(ServerRequest $request)
    {

        try {
            $validated = $request->validated();
            $status = $this->serverStatusService->checkServerStatus($validated['server_ip'], $validated['server_port']);
            if (!$status['success']) {
                return back()->withInput()->withErrors(['server_ip' => $status['message']]);
            }
            $validated['logo_image'] = $status['server_data']['icon'];
            $validated['motd'] = implode('<br> ', $status['server_data']['motd']['html']);
            $validated['minecraft_version'] = $status['server_data']['protocol']['name'];
            $validated['max_players'] = $status['server_data']['players']['max'];
            $validated['current_players'] = $status['server_data']['players']['online'];
            $validated['server_port'] = $validated['server_port'] ? $validated['server_port'] : $status['server_data']['port'];
            $validated['server_datas'] = $status['server_data'];
            $validated['is_approved'] = true;
            $validated['user_id'] = Auth::id();

            $validated['is_online'] = true;

            $country = $this->serverStatusService->getCountryCode($validated['server_ip']);
            $country = json_decode($country, true);
            if (!empty($country)) {
                $country = ServerCountry::where('code', $country['countryCode'])->first();
                if ($country) {
                    $validated['country_id'] = $country->id;
                }
            }
            DB::transaction(function () use ($validated, $request) {
                // Upload banner image if present
                if ($request->hasFile('banner_image')) {
                    $validated['banner_image'] = $request->file('banner_image')->store('uploads/server_banners', 'public');
                }

                $validated['terms_accepted'] = true;
                $server = ServerListing::create($validated);

                foreach ($validated['tags'] as $tag) {
                    ServerTag::create([
                        'server_id' => $server->id,
                        'tag_id' => $tag,
                        'created_at' => now(),
                    ]);
                }
            });
            return to_route('home')
                ->with('success', trans('messages.status.success'));
        } catch (Throwable $e) {
            Log::error('Failed to create server', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            throw $e;
        }
    }
    public function userDashboard()
    {
        return view('server-listing::user.bidding_dashboard');
    }

    public function serverList()
    {

        $myServers = ServerListing::where('user_id', Auth::id())
            ->withCount('favorites')
            ->with('bids', function ($query) {
                $query->whereMonth('bidding_at', now()->month)
                    ->whereYear('bidding_at', now()->year);
            })
            ->orderBy('server_rank', 'asc')
            ->get();
        return view('server-listing::user.server_listing', compact('myServers'));
    }
    public function my_favorite_servers()
    {

        $myServers = ServerListing::whereHas('favorites', function ($query) {
            $query->where('user_id', Auth::id());
        })->orderBy('server_rank', 'asc')
            ->get();

        return view('server-listing::user.favorite_servers', compact('myServers'));
    }


    public function favorite(string $slug)
    {
        $server = ServerListing::where('slug', $slug)->firstOrFail();

        if (Auth::check()) {
            $favorite = $server->favorites()->where('user_id', Auth::id())->first();

            if ($favorite) {
                $favorite->delete();
                return back()->with('success', trans('messages.status.unfavorite'));
            } else {
                $server->favorites()->create([
                    'user_id' => Auth::id(),
                ]);
                return back()->with('success', trans('messages.status.favorite'));
            }
        } else {
            return back()->with('error', trans('messages.status.unauthorized'));
        }
    }

    public function search()
    {
        $versions = Http::get('https://launchermeta.mojang.com/mc/game/version_manifest.json')
            ->json('versions');
        $data['minecraft_versions'] = collect($versions)
            // ->filter(fn($version) => $version['type'] === 'release')
            ->pluck('id')
            ->values();

        $data['countries'] = ServerCountry::active()->ordered()->get();
        $data['tags'] = Tag::active()->ordered()->get();
        return view('server-listing::search', $data);
    }


    public function filter(Request $request)
    {
        $validated = $request->validate([
            'keyword' => 'nullable|string|max:255',
            'version' => 'nullable|string|max:50',
            'country' => 'nullable|exists:server_countries,id',
            'online_min_players' => 'nullable|integer|min:0',
            'online_max_players' => 'nullable|integer|min:0',
            'min_total_players' => 'nullable|integer|min:1',
            'max_total_players' => 'nullable|integer|min:1',
            'order_by' => 'nullable|in:server_rank,current_players,max_players',
            'with_teamspeak' => 'nullable|boolean',
            'with_discord' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|exists:server_tags,id',
        ]);


        return redirect()->route('server-listing.search.result', $validated);
    }

    public function result(Request $request)
    {
        $query = ServerListing::with(['country', 'user', 'serverTags'])->approved();

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%')
                    ->orWhere('server_ip', 'like', '%' . $keyword . '%')
                    ->orWhere('minecraft_version', 'like', '%' . $keyword . '%')
                    ->orWhere('website_url', 'like', '%' . $keyword . '%')
                    ->orWhereHas('country', function ($subQuery) use ($keyword) {
                        $subQuery->where('name', 'like', '%' . $keyword . '%');
                    })
                    ->orWhereHas('serverTags', function ($subQuery) use ($keyword) {
                        $subQuery->where('name', 'like', '%' . $keyword . '%');
                    });
            });
        }

        if ($request->filled('version') && $request->input('version') !== 'all') {
            $query->where('minecraft_version', $request->input('version'));
        }

        if ($request->filled('country') && $request->input('country') !== 'all') {
            $query->whereHas('country', function ($q) use ($request) {
                $q->where('slug', $request->input('country'));
            });
        }

        if ($request->filled('tags')) {
            $query->whereHas('serverTags', function ($q) use ($request) {
                $q->whereIn('id', $request->input('tags'));
            });
        }

        if ($request->filled('online_min_players')) {
            $query->where('current_players', '>=', $request->input('online_min_players'));
        }

        if ($request->filled('online_max_players')) {
            $query->where('current_players', '<=', $request->input('online_max_players'));
        }
        if ($request->filled('min_total_players')) {
            $query->where('max_players', '>=', $request->input('min_total_players'));
        }

        if ($request->filled('max_total_players')) {
            $query->where('max_players', '<=', $request->input('max_total_players'));
        }

        if ($request->filled('order_by')) {
            $query->orderBy($request->input('order_by'), 'asc');
        }

        $data['server_listings'] = $query->paginate(10);
        return view('server-listing::search-result', $data);
    }
}
