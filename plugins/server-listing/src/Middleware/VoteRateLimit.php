<?php

namespace Azuriom\Plugin\ServerListing\Middleware;

class VoteRateLimit
{
    public function handle($request, Closure $next)
    {
        $maxAttempts = config('voting.validation.rate_limit.max_attempts');
        $decayMinutes = config('voting.validation.rate_limit.decay_minutes');

        $key = 'vote_attempts:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);

            return response()->json([
                'success' => false,
                'message' => "Too many vote attempts. Try again in {$seconds} seconds.",
                'retry_after' => $seconds
            ], 429);
        }

        RateLimiter::hit($key, $decayMinutes * 60);

        return $next($request);
    }
}
