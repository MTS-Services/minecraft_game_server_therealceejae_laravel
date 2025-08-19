<?php

use Azuriom\Azuriom;

/*
|--------------------------------------------------------------------------
| Base helpers
|--------------------------------------------------------------------------
|
| Here is where are registered the helpers that should override a Laravel
| helper because this file is load before the entire framework.
|
*/

if (! function_exists('asset')) {
    /**
     * Generate an asset path for the application.
     */
    function asset(string $path, ?bool $secure = null): string
    {
        // Ignore if there is already a query string
        $query = str_contains($path, '?') ? '' : '?v'.Azuriom::version();

        return app('url')->asset('assets/'.$path.$query, $secure);
    }
}

// function biddingIsOpen(): bool
// {
//     $day = now()->day; // today day of month
//     return $day >= 20 && $day < 29;
// }
function biddingIsOpen(): bool
{
    $day = now()->day;
    return $day >= 20 && $day < lastPaymentDayStart();
}

function paymentIsOpen(): bool
{
    $day = now()->day;
    return $day >= lastPaymentDayStart() && $day <= lastDayOfMonth();
}

function lastPaymentDayStart(): int
{
    $lastDay = lastDayOfMonth();
    return $lastDay - 2;
}

function lastDayOfMonth(): int
{
    return now()->endOfMonth()->day; // 28 / 29 / 30 / 31
}


