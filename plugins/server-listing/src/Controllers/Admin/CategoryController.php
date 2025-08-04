<?php

namespace Azuriom\Plugin\ServerListing\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Models\ServerCategory;
use Azuriom\Plugin\ServerListing\Requests\CategoryRequest;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{

    public function index()
    {
        $data['categories'] = ServerCategory::orderBy('sort_order', 'asc')
            ->paginate(10);
        return view('server-listing::admin.categories.index', $data);
    }

    public function create()
    {
        return view('server-listing::admin.categories.create', );
    }

    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();
        ServerCategory::create($validated);
        return to_route('server-listing.admin.categories.index')
            ->with('success', trans('messages.status.success'));
    }

    public function edit($server_slug)
    {

        $data['category'] = ServerCategory::where('slug', $server_slug)->first();
        return view('server-listing::admin.categories.edit', $data);
    }



    public function update(CategoryRequest $request, string $server_slug): RedirectResponse
    {
        $validated = $request->validated();

        $category = ServerCategory::where('slug', $server_slug)->first();
        $category->update($validated);

        return to_route('server-listing.admin.categories.index')
            ->with('success', trans('messages.status.success'));
    }

    public function destroy(string $server_slug)
    {
        $server = ServerCategory::where('slug', $server_slug)->first();
        $server->delete();
        return redirect()->route('server-listing.admin.categories.index')->with('success', trans('messages.status.success'));
    }
}
