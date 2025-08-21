<?php

namespace Azuriom\Plugin\ServerListing\Rule;

use Azuriom\Plugin\ServerListing\Models\ServerVote;
use Illuminate\Contracts\Validation\Rule;

class UniqueVoteRule implements Rule
{
    protected $server;

    public function __construct($server)
    {
        $this->server = $server;
    }

    public function passes($attribute, $value)
    {
        $cooldownHours = config('voting.cooldown.hours');
        $checkIP = config('voting.cooldown.per_ip');
        $checkUsername = config('voting.cooldown.per_username');

        $query = ServerVote::where('server_id', $this->server->id)
            ->where('next_vote_at', '>', now());

        if ($checkUsername && $checkIP) {
            $query->where(function ($q) use ($value) {
                $q->where('username', $value)
                    ->orWhere('ip_address', request()->ip());
            });
        } elseif ($checkUsername) {
            $query->where('username', $value);
        } elseif ($checkIP) {
            $query->where('ip_address', request()->ip());
        }

        return !$query->exists();
    }

    public function message()
    {
        $cooldownHours = config('voting.cooldown.hours');
        return "You can only vote once every {$cooldownHours} hours.";
    }
}
