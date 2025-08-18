<?php

namespace Azuriom\Plugin\ServerListing\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Models\ServerListing;

class VoteController extends Controller
{
    public function index($slug)
    {
        $server = ServerListing::where('slug', $slug)->firstOrFail();
        return view('server-listing::vote', compact('server'));
    }
}
