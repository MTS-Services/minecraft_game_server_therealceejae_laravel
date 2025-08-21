<?php

namespace Azuriom\Plugin\ServerListing\Controllers;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a view on success payment.
     *
     * @return \Illuminate\Http\Response
     */
    public function success(Request $request)
    {
        return view('shop::payments.success');
    }
}
