<?php

namespace Azuriom\Plugin\TestNewPlugin\Controllers;

use Azuriom\Http\Controllers\Controller;

class TestNewPluginHomeController extends Controller
{
    /**
     * Show the home plugin page.
     */
    public function index()
    {
        return view('test-new-plugin::index');
    }
}
