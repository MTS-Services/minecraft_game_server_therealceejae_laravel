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
}
