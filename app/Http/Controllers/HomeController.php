<?php

namespace Azuriom\Http\Controllers;

use Azuriom\Models\Post;
use Azuriom\Plugin\ServerListing\Models\ServerCountry;
use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Azuriom\Plugin\ServerListing\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;

class HomeController extends Controller
{
    // Make sure to inject Request here to access query parameters
    public function index(Request $request)
    {


        if (plugins()->isEnabled('server-listing')) {
            $data['server_countries'] = ServerCountry::active()->ordered()->get();
            $data['tags'] = Tag::active()->ordered()->get();



            $versions = Http::get('https://launchermeta.mojang.com/mc/game/version_manifest.json')
                ->json('versions');
            $data['minecraft_versions'] = collect($versions)
                // ->filter(fn($version) => $version['type'] === 'release')
                ->pluck('id')
                ->values();

            $query = ServerListing::with(['country', 'user']);
            $search = false;
            if ($request->has('search') && $request->get('search') != '') {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('server_ip', 'like', '%' . $search . '%')
                        ->orWhere('minecraft_version', 'like', '%' . $search . '%')
                        ->orWhere('website_url', 'like', '%' . $search . '%')
                        ->orWhereHas('country', function ($subQuery) use ($search) {
                            $subQuery->where('name', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('serverTags', function ($subQuery) use ($search) {
                            $subQuery->where('name', 'like', '%' . $search . '%');
                        });
                });
                $search = true;
            }
            if (request()->has('country') && request()->get('country') !== 'all') {
                $search = true;
                $query->whereHas('country', function ($q) {
                    $q->where('slug', request()->get('country'));

                });
            }
            if (request()->has('tag') && request()->get('tag') !== 'all') {
                $search = true;
                $query->whereHas('serverTags', function ($q) {
                    $q->where('slug', request()->get('tag'));

                });
            }
            if (request()->has('minecraft_version') && request()->get('minecraft_version') !== 'all') {
                $search = true;
                $query->where('minecraft_version', request()->get('minecraft_version'));
            }
            if ($search) {
                $data['servers'] = $query->approved()->orderByRank();
            } else {
                $data['servers'] = $query->approved()->orderBy('server_rank', 'asc');
            }



            // --- Popular Servers Pagination ---
            // Get 'popular_page' from the request, default to 1
            $popularPage = request()->query('popular_page', 1);
            $data['popularServers'] = $query->paginate(10, ['*'], 'popular_page', $popularPage);



            if (!$search) {
                $data['topServers'] = ServerListing::with(['country', 'user', 'serverTags'])
                    ->featured()
                    ->premium()
                    ->approved()
                    ->orderBy('position', 'asc')
                    ->take(10)
                    ->get();

                // // --- Premium Servers Pagination ---
                // // Get 'premium_page' from the request, default to 1
                // $premiumPage = request()->query('premium_page', 1);
                // $data['premiumServers'] = ServerListing::with(['country', 'user', 'serverTags'])
                //     ->notFeatured()
                //     ->premium()
                //     ->approved()
                //     ->orderBy('position', 'asc')
                //     // Use 'premium_page' as the pagination parameter
                //     ->paginate(10, ['*'], 'premium_page', $premiumPage);
            }
        }

        $data['message'] = new HtmlString(setting('home_message'));

        // Pass the entire request object to the view for generating correct pagination links
        return view('home', $data)->with('request', $request);
    }
}
