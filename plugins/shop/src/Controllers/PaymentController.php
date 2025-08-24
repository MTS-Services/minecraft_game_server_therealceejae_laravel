<?php

namespace Azuriom\Plugin\Shop\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Models\ServerBid;
use Azuriom\Plugin\Shop\Cart\Cart;
use Azuriom\Plugin\Shop\Models\Gateway;
use Azuriom\Plugin\Shop\Models\Payment;
use Azuriom\Plugin\Shop\Payment\PaymentManager;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $cart = Cart::fromSession($request->session());

        // If the cart isn't empty and the total is 0, just complete
        // the payment now as gateways won't accept null payment
        if (! $cart->isEmpty() && $cart->payableTotal() < 0.1) {
            PaymentManager::createPayment($cart, 0, currency(), 'free')->deliver();

            $cart->destroy();

            return to_route('shop.home')->with('success', trans('shop::messages.cart.success'));
        }

        $gateways = Gateway::enabled()
            ->get()
            ->filter(fn(Gateway $gateway) => $gateway->isSupported())
            ->reject(fn(Gateway $gateway) => $gateway->paymentMethod()->hasFixedAmount());

        // If there is only one payment gateway, redirect to it directly
        if ($gateways->count() === 1) {
            $gateway = $gateways->first();

            return $gateway->paymentMethod()->startPayment($cart, $cart->payableTotal(), currency());
        }

        return view('shop::payments.pay', ['gateways' => $gateways]);
    }

    /**
     * Start a new payment.
     */
    public function pay(Request $request, Gateway $gateway)
    {
        abort_if(! $gateway->is_enabled, 403);

        $cart = Cart::fromSession($request->session());

        if ($cart->isEmpty()) {
            return to_route('shop.cart.index');
        }

        return $gateway->paymentMethod()->startPayment($cart, $cart->payableTotal(), currency());
    }

    public function success(Request $request, Gateway $gateway)
    {
        $transactionId = decrypt(session()->get('payment_transaction_id'));
        session()->forget('payment_transaction_id');

        if ($transactionId) {
            $payment = Payment::where('transaction_id', $transactionId)->first();
            $payment->update(['status' => 'completed']);
            // if ($payment->bid_id !== null) {
            //     $bid = ServerBid::where('id', $payment->bid_id)->update(['status' => 'completed']);
            // }
        }

        $response = $gateway->paymentMethod()->success($request);

        $cart = Cart::fromSession($request->session());

        $cart->destroy();

        return $response;
    }

    public function failure(Request $request, Gateway $gateway)
    {
        $transactionId = decrypt(session()->get('payment_transaction_id'));
        session()->forget('payment_transaction_id');

        if ($transactionId) {
            Payment::where('transaction_id', $transactionId)->update(['status' => 'failed']);
        }

        return $gateway->paymentMethod()->failure($request);
    }
}
