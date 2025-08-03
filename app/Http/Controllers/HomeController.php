<?php

namespace Azuriom\Http\Controllers;

use Azuriom\Models\Post;
use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Illuminate\Support\HtmlString;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $data['posts'] = Post::published()
            ->with('author')
            ->latest('published_at')
            ->take(5)
            ->get();

        if (plugins()->isEnabled('server-listing')) {
            $data['topServers'] = ServerListing::with(['category', 'user'])
                ->featured()
                ->premium()
                ->approved()
                ->orderBy('sort_order', 'asc')
                ->take(10)
                ->get();

            $data['premiumServers'] = ServerListing::with(['category', 'user'])
                ->notFeatured()
                ->premium()
                ->approved()
                ->orderBy('sort_order', 'asc')
                ->paginate(10);
            $data['popularServers'] = ServerListing::with(['category', 'user'])
                ->notPremium()
                ->approved()
                ->orderByPopularity()
                ->paginate(10);
        }

        $data['message'] = new HtmlString(setting('home_message'));

        return view('home', $data);
    }
}
