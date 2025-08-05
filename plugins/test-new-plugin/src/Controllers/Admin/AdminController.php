<?php

namespace Azuriom\Plugin\TestNewPlugin\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Show the home admin page of the plugin.
     */
    public function index()
    {
        return view('test-new-plugin::admin.index');
    }
}
