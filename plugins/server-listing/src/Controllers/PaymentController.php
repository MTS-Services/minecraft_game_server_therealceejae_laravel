<?php

namespace Azuriom\Plugin\ServerListing\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Shop\Cart\Cart;
use Azuriom\Plugin\Shop\Models\Gateway;
use Azuriom\Plugin\Shop\Payment\PaymentManager;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment()
    {

        $gateways = Gateway::enabled()
            ->get()
            ->filter(fn(Gateway $gateway) => $gateway->isSupported())
            ->reject(fn(Gateway $gateway) => $gateway->paymentMethod()->hasFixedAmount());

        // If there is only one payment gateway, redirect to it directly
        if ($gateways->count() === 1) {
            $gateway = $gateways->first();
            dd($gateway);
            // return $gateway->paymentMethod()->startPayment($cart, $cart->payableTotal(), currency());
        }

        return view('server-listing::payment.gateways', ['gateways' => $gateways]);
    }


    public function pay(Request $request, Gateway $gateway)
    {
        abort_if(! $gateway->is_enabled, 403);

        dd($gateway);

        $cart = Cart::fromSession($request->session());

        if ($cart->isEmpty()) {
            return to_route('shop.cart.index');
        }

        return $gateway->paymentMethod()->startPayment($cart, $cart->payableTotal(), currency());
    }

    // public function success(Request $request, Gateway $gateway)
    // {
    //     $response = $gateway->paymentMethod()->success($request);

    //     $cart = Cart::fromSession($request->session());

    //     $cart->destroy();

    //     return $response;
    // }

    // public function failure(Request $request, Gateway $gateway)
    // {
    //     return $gateway->paymentMethod()->failure($request);
    // }
}
