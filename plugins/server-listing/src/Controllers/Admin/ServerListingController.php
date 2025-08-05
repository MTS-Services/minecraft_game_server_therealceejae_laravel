<?php

namespace Azuriom\Plugin\ServerListing\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Requests\ServerRequest;
use Azuriom\Models\User;
use Azuriom\Plugin\ServerListing\Models\ServerCategory;
use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ServerListingController extends Controller
{
    /**
     * Show the home admin page of the plugin.
     */
    public function index()
    {
        $data['servers'] = ServerListing::with('category')
            ->orderBy('position', 'asc')
            ->paginate(10);
        return view('server-listing::admin.servers.index', $data);
    }

    public function create()
    {
        $data['users'] = User::nonAdmins()->verified()->latest()->get();
        $data['categories'] = ServerCategory::active()->latest()->get();
        return view('server-listing::admin.servers.create', $data);
    }

    public function store(ServerRequest $request)
    {
        $validated = $request->validated();
        // $validated['tags'] = json_encode($validated['tags']);
        // Upload logo image if present
        if ($request->hasFile('logo_image')) {
            $validated['logo_image'] = $request->file('logo_image')->store('uploads/server_logos', 'public');
        }

        // Upload banner image if present
        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('uploads/server_banners', 'public');
        }
        ServerListing::create($validated);

        return to_route('server-listing.admin.servers.index')
            ->with('success', trans('messages.status.success'));
    }

    public function edit($server_slug)
    {
        $data['users'] = User::nonAdmins()->verified()->latest()->get();
        $data['categories'] = ServerCategory::active()->latest()->get();
        $data['server'] = ServerListing::where('slug', $server_slug)->first();
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
