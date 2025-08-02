<?php

namespace Azuriom\Plugin\ServerListing\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Models\ServerListing;

class AdminController extends Controller
{
    /**
     * Show the home admin page of the plugin.
     */
    public function index()
    {
        $data['servers'] = ServerListing::with('category')
            ->orderBy('sort_order', 'asc')
            ->paginate(10);
        return view('server-listing::admin.servers.index', $data);
    }
}
