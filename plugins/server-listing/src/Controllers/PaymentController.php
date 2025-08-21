<?php

namespace Azuriom\Plugin\ServerListing\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Shop\Cart\Cart;
use Azuriom\Plugin\Shop\Models\Gateway;
use Azuriom\Plugin\Shop\Payment\PaymentManager;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        dd($request);
    }
}
