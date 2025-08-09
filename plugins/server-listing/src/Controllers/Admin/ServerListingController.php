<?php

namespace Azuriom\Plugin\ServerListing\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Models\ServerCountry;
use Azuriom\Plugin\ServerListing\Models\ServerTag;
use Azuriom\Plugin\ServerListing\Models\Tag;
use Azuriom\Plugin\ServerListing\Requests\ServerRequest;
use Azuriom\Models\User;
use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Azuriom\Plugin\ServerListing\Services\ServerStatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ServerListingController extends Controller
{

    protected ServerStatusService $serverStatusService;

    public function __construct(ServerStatusService $serverStatusService)
    {
        $this->serverStatusService = $serverStatusService;
    }

    public function index()
    {
        $data['per_page'] = 10;
        $data['servers'] = ServerListing::with(['user', 'country'])->latest()
            ->paginate($data['per_page']);
        return view('server-listing::admin.servers.index', $data);
    }

    public function updateOrder(Request $request)
    {
        try {
            // Validate input
            $validator = Validator::make($request->all(), [
                'order.*.id' => ['required', 'integer'],
                'order.*.children' => ['sometimes', 'array'],
                'page' => ['nullable', 'integer'],
                'per_page' => ['nullable', 'integer'],
            ]);

            if ($validator->fails()) {
                Log::warning('Tag reorder validation failed', [
                    'errors' => $validator->errors(),
                    'payload' => $request->all(),
                ]);

                return response()->json([
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $elements = $request->input('order');
            $page = $request->input('page', 1);
            $perPage = $request->input('per_page', 10);
            $position = ($page - 1) * $perPage + 1; // starting position offset for the current page

            foreach ($elements as $element) {
                $id = $element['id'];
                $children = $element['children'] ?? [];

                ServerListing::whereKey($id)->update([
                    'position' => $position++,
                ]);

                $childPosition = 1;

                foreach ($children as $child) {
                    ServerListing::whereKey($child['id'])->update([
                        'position' => $childPosition++,
                    ]);
                }
            }

            return response()->json([
                'message' => trans('messages.status.success'),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update tag order', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            return response()->json([
                'message' => 'Something went wrong while saving the order.',
            ], 500);
        }
    }

    public function create()
    {
        $data['users'] = User::nonAdmins()->verified()->latest()->get();
        $data['tags'] = Tag::active()->ordered()->get();
        $data['countries'] = ServerCountry::ordered()->active()->get();
        return view('server-listing::admin.servers.create', $data);
    }

    public function store(ServerRequest $request)
    {

        try {
            $validated = $request->validated();
            $status = $this->serverStatusService->checkServerStatus($validated['server_ip'], $validated['server_port']);

            $validated['logo_image'] = $status['server_data']['icon'];
            $validated['motd'] = implode('<br> ', $status['server_data']['motd']['html']);
            $validated['minecraft_version'] = $status['server_data']['version'];
            $validated['max_players'] = $status['server_data']['players']['max'];
            $validated['current_players'] = $status['server_data']['players']['online'];
            $validated['server_port'] = $validated['server_port'] ? $validated['server_port'] : $status['server_data']['port'];
            $validated['server_datas'] = $status['server_data'];


            if (!$status['success']) {
                return back()->withInput()->withErrors(['server_ip' => $status['message']]);
            }
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
            return to_route('server-listing.admin.servers.index')
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

    public function edit($server_slug)
    {
        $data['users'] = User::nonAdmins()->verified()->latest()->get();
        $data['tags'] = Tag::active()->latest()->get();
        $data['countries'] = ServerCountry::ordered()->active()->get();
        $data['server'] = ServerListing::where('slug', $server_slug)->with(['serverTags', 'user', 'country'])->first();
        return view('server-listing::admin.servers.edit', $data);
    }



    public function update(ServerRequest $request, string $server_slug): RedirectResponse
    {
        try {
            $validated = $request->validated();
            $server = ServerListing::where('slug', $server_slug)->firstOrFail();

            // 1. Check the server status first
            $status = $this->serverStatusService->checkServerStatus($validated['server_ip'], $validated['server_port']);

            // 2. If the connection check fails, return an error back to the form.
            if (!$status['success']) {
                return back()->withInput()->withErrors(['server_ip' => $status['message']]);
            }

            // 3. Update validated data with server status information
            // We'll only update the icon if the API provided a new one.
            if (isset($status['server_data']['icon'])) {
                $validated['logo_image'] = $status['server_data']['icon'];
            }
            $validated['motd'] = implode('<br> ', $status['server_data']['motd']['html']);
            $validated['minecraft_version'] = $status['server_data']['version'];
            $validated['max_players'] = $status['server_data']['players']['max'];
            $validated['current_players'] = $status['server_data']['players']['online'];
            $validated['server_port'] = $validated['server_port'] ? $validated['server_port'] : $status['server_data']['port'];
            $validated['server_datas'] = $status['server_data'];

            // 4. Get the country code and update the country ID
            $country = $this->serverStatusService->getCountryCode($validated['server_ip']);
            $country = json_decode($country, true);
            if (!empty($country)) {
                $serverCountry = ServerCountry::where('code', $country['countryCode'])->first();
                if ($serverCountry) {
                    $validated['country_id'] = $serverCountry->id;
                }
            }
            dd($validated);

            DB::transaction(function () use ($validated, $request, $server) {
                // Delete old logo if a new one from the API is being saved.
                // This is only if you were previously storing file paths. If you store Base64, this isn't needed.
                // Since your `store` method now stores the Base64, we will assume that's the approach.
                // If you later switch back to file storage, you'll need to re-add the deletion logic here.

                // Handle banner image upload
                if ($request->hasFile('banner_image')) {
                    // Delete old banner if exists
                    if ($server->banner_image && Storage::disk('public')->exists($server->banner_image)) {
                        Storage::disk('public')->delete($server->banner_image);
                    }
                    $validated['banner_image'] = $request->file('banner_image')->store('uploads/server_banners', 'public');
                }

                // Update the server record
                $server->update($validated);

                // Sync tags
                if (isset($validated['tags'])) {
                    $server->serverTags()->delete(); // Remove existing tags
                    foreach ($validated['tags'] as $tagId) {
                        ServerTag::create([
                            'server_id' => $server->id,
                            'tag_id' => $tagId,
                            'created_at' => now(),
                        ]);
                    }
                }
            });

            return to_route('server-listing.admin.servers.index')
                ->with('success', trans('messages.status.success'));
        } catch (Throwable $e) {
            Log::error('Failed to update server', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            throw $e;
        }
    }

    public function destroy(string $server_slug)
    {
        $server = ServerListing::where('slug', $server_slug)->first();
        Storage::disk('public')->delete($server->logo_image);
        Storage::disk('public')->delete($server->banner_image);
        $server->delete();
        return redirect()->route('server-listing.admin.servers.index')->with('success', trans('messages.status.success'));
    }
}
