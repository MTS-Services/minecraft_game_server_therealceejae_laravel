<?php

namespace Azuriom\Plugin\ServerListing\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Models\Tag;
use Azuriom\Plugin\ServerListing\Requests\TagRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{

    public function index()
    {
        $data['per_page'] = 10;
        $data['tags'] = Tag::ordered()->paginate($data['per_page']);
        return view('server-listing::admin.tags.index', $data);
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

                Tag::whereKey($id)->update([
                    'position' => $position++,
                ]);

                $childPosition = 1;

                foreach ($children as $child) {
                    Tag::whereKey($child['id'])->update([
                        'position' => $childPosition++,
                    ]);
                }
            }

            // Tag::clearCache();

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
        return view('server-listing::admin.tags.create', );
    }

    public function store(TagRequest $request)
    {
        $validated = $request->validated();
        Tag::create($validated);
        return to_route('server-listing.admin.tags.index')
            ->with('success', trans('messages.status.success'));
    }

    public function edit($tag_slug)
    {

        $data['tag'] = Tag::where('slug', $tag_slug)->first();
        return view('server-listing::admin.tags.edit', $data);
    }



    public function update(TagRequest $request, string $tag_slug): RedirectResponse
    {
        $validated = $request->validated();

        $tag = Tag::where('slug', $tag_slug)->first();
        $tag->update($validated);

        return to_route('server-listing.admin.tags.index')
            ->with('success', trans('messages.status.success'));
    }

    public function destroy(string $tag_slug)
    {
        $tag = Tag::where('slug', $tag_slug)->first();
        $tag->delete();
        return redirect()->route('server-listing.admin.tags.index')->with('success', trans('messages.status.success'));
    }
}
