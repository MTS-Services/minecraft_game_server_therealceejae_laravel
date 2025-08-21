<?php

namespace Azuriom\Plugin\ServerListing\Mail;

class VoteReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $vote;
    public $server;

    public function __construct(Vote $vote, Server $server)
    {
        $this->vote = $vote;
        $this->server = $server;
    }

    public function build()
    {
        return $this->subject("New vote received for {$this->server->name}")
            ->view('emails.vote-received')
            ->with([
                'vote' => $this->vote,
                'server' => $this->server,
                'dashboardUrl' => route('server-listing.admin.votes.show', $this->server->id)
            ]);
    }
}

// 10. MIDDLEWARE FOR VOTE RATE LIMITING
// app/Http/Middleware/VoteRateLimit.php
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
