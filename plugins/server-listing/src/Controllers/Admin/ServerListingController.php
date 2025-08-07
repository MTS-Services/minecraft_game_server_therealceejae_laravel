<?php

namespace Azuriom\Plugin\ServerListing\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Models\ServerCountry;
use Azuriom\Plugin\ServerListing\Models\ServerTag;
use Azuriom\Plugin\ServerListing\Models\Tag;
use Azuriom\Plugin\ServerListing\Requests\ServerRequest;
use Azuriom\Models\User;
use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ServerListingController extends Controller
{
    /**
     * Show the home admin page of the plugin.
     */
    public function index()
    {
        $data['per_page'] = 10;
        $data['servers'] = ServerListing::with(['user', 'country'])->ordered()
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
        dd($request->all());
        DB::transaction(function () use ($request) {
            $validated = $request->validated();
            if ($request->hasFile('logo_image')) {
                $validated['logo_image'] = $request->file('logo_image')->store('uploads/server_logos', 'public');
            }

            // Upload banner image if present
            if ($request->hasFile('banner_image')) {
                $validated['banner_image'] = $request->file('banner_image')->store('uploads/server_banners', 'public');
            }
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
        $validated = $request->validated();

        $server = ServerListing::where('slug', $server_slug)->first();

        // Encode tags as JSON
        // $validated['tags'] = json_encode($validated['tags'] ?? []);

        // Handle logo image upload
        if ($request->hasFile('logo_image')) {
            // Delete old logo if exists
            if ($server->logo_image && Storage::disk('public')->exists($server->logo_image)) {
                Storage::disk('public')->delete($server->logo_image);
            }

            $validated['logo_image'] = $request->file('logo_image')->store('uploads/server_logos', 'public');
        }

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            // Delete old banner if exists
            if ($server->banner_image && Storage::disk('public')->exists($server->banner_image)) {
                Storage::disk('public')->delete($server->banner_image);
            }

            $validated['banner_image'] = $request->file('banner_image')->store('uploads/server_banners', 'public');
        }

        $server->update($validated);

        return to_route('server-listing.admin.servers.index')
            ->with('success', trans('messages.status.success'));
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
