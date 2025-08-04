<?php

namespace Azuriom\Http\Controllers;

use Azuriom\Models\Post;
use Azuriom\Plugin\ServerListing\Models\ServerCategory;
use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;

class HomeController extends Controller
{
    // Make sure to inject Request here to access query parameters
    public function index(Request $request)
    {



        if (plugins()->isEnabled('server-listing')) {
            $data['server_categories'] = ServerCategory::active()->latest()->get();
            $data['server_versions'] = ServerListing::pluck('version')->unique()->toArray();

            $query = ServerListing::with(['category', 'user']);
            $search = false;
            if ($request->has('search') && $request->get('search') != '') {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('server_ip', 'like', '%' . $search . '%')
                        ->orWhereJsonContains('tags', $search)
                        ->orWhere('version', 'like', '%' . $search . '%')
                        ->orWhere('website_url', 'like', '%' . $search . '%')
                        ->orWhereHas('category', function ($subQuery) use ($search) {
                            $subQuery->where('name', 'like', '%' . $search . '%');
                        });
                });
                $search = true;
            }
            if (request()->has('category') && request()->get('category') !== 'all') {
                $search = true;
                $server_category = ServerCategory::where('slug', request()->get('category'))->first();
                $query->where('category_id', $server_category->id);
            }
            if (request()->has('version') && request()->get('version') !== 'all') {
                $search = true;
                $query->where('version', request()->get('version'));
            }
            if ($search) {
                $data['servers'] = $query->approved()->orderBy('is_featured', 'desc')->orderBy('is_premium', 'desc')->orderBy('sort_order')->orderBy('name');
            } else {
                $data['servers'] = $query->approved()->notPremium()->orderByPopularity();
            }



            // --- Popular Servers Pagination ---
            // Get 'popular_page' from the request, default to 1
            $popularPage = request()->query('popular_page', 1);
            $data['popularServers'] = $query->paginate(2, ['*'], 'popular_page', $popularPage);



            if (!$search) {
                $data['topServers'] = ServerListing::with(['category', 'user'])
                    ->featured()
                    ->premium()
                    ->approved()
                    ->orderBy('sort_order', 'asc')
                    ->take(10)
                    ->get();

                // --- Premium Servers Pagination ---
                // Get 'premium_page' from the request, default to 1
                $premiumPage = request()->query('premium_page', 1);
                $data['premiumServers'] = ServerListing::with(['category', 'user'])
                    ->notFeatured()
                    ->premium()
                    ->approved()
                    ->orderBy('sort_order', 'asc')
                    // Use 'premium_page' as the pagination parameter
                    ->paginate(1, ['*'], 'premium_page', $premiumPage);
            }



        }

        $data['message'] = new HtmlString(setting('home_message'));

        // Pass the entire request object to the view for generating correct pagination links
        return view('home', $data)->with('request', $request);
    }
}
