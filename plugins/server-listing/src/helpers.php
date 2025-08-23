<?php

use Azuriom\Plugin\ServerListing\Payment\PaymentManager;

if (!function_exists('server_payment_manager')) {
    function server_payment_manager(): PaymentManager
    {
        // dd('app(PaymentManager::class)');
        return app(PaymentManager::class);
    }
}

// function biddingIsOpen(): bool
// {
//     $day = now()->day; // today day of month
//     return $day >= 20 && $day < 29;
// }
if (!function_exists('biddingStartDay')) {
    function biddingStartDay(): int
    {
        return 20;
    }
}
if (!function_exists('biddingIsOpen')) {
    function biddingIsOpen(): bool
    {
        $day = now()->day;
        return $day >= biddingStartDay() && $day < paymentStartDay();
    }
}
if (!function_exists('paymentIsOpen')) {
    function paymentIsOpen(): bool
    {
        $day = now()->day;
        return $day >= paymentStartDay() && $day <= lastDayOfMonth();
    }
}
if (!function_exists('paymentStartDay')) {
    function paymentStartDay(): int
    {
        $lastDay = lastDayOfMonth();
        return $lastDay - 2;
    }
}

if (!function_exists('lastDayOfMonth')) {
    function lastDayOfMonth(): int
    {
        return now()->endOfMonth()->day; // 28 / 29 / 30 / 31
    }
}
