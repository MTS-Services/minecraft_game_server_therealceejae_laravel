<?php

use Azuriom\Plugin\ServerListing\Payment\PaymentManager;

if (!function_exists('server_payment_manager')) {
    function server_payment_manager(): PaymentManager
    {
        // dd('app(PaymentManager::class)');
        return app(PaymentManager::class);
    }
}
