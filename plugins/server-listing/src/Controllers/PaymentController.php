<?php

namespace Azuriom\Plugin\ServerListing\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Models\ServerBid;
use Azuriom\Plugin\Shop\Cart\Cart;
use Azuriom\Plugin\Shop\Models\Gateway;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function payment(Request $request, string $encryptedId)
    {
        $bid = ServerBid::findOrFail(decrypt($encryptedId));
        $cart = Cart::fromSession($request->session());

        if (!$cart->has($bid)) {
            $cart->add($bid);
        }
        $gateways = Gateway::enabled()
            ->get()
            ->filter(fn(Gateway $gateway) => $gateway->isSupported())
            ->reject(fn(Gateway $gateway) => $gateway->paymentMethod()->hasFixedAmount());

        if ($gateways->count() === 0) {
            return redirect()->back()->with('error', 'No payment gateways available');
        }
        if ($gateways->count() === 1) {

            $gateway = $gateways->first();
            // dd($gateway);

            return $gateway->paymentMethod()->startPayment($cart, $cart->payableTotal(), currency(), serverID: $bid?->serverListing?->id);
        }
        return view('server-listing::payment.gateways', ['gateways' => $gateways, 'bid' => $bid]);
    }


    /**
     * Display a view on success payment.
     *
     * @return \Illuminate\Http\Response
     */
    public function pay(Request $request, Gateway $gateway)
    {
        abort_if(!$gateway->is_enabled, 403);

        $cart = Cart::fromSession($request->session());
        $bid = ServerBid::findOrFail(decrypt($request->input('bid_id')));

        if (!$cart->has($bid)) {
            $cart->add($bid);
        }
        $bid->load('serverListing');

        if ($cart->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty');
        }

        return $gateway->paymentMethod()->startPayment($cart, $cart->payableTotal(), currency(), serverID: $bid?->serverListing?->id);
    }

}
