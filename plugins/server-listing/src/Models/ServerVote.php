<?php

namespace Azuriom\Plugin\ServerListing\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServerVote extends Model
{
    use HasTablePrefix;
    protected $table = 'server_listing_votes';

    protected $fillable = [
        'server_id',
        'username',
        'ip_address',
        'voted_at',
        'next_vote_at',
        'reward_sent',
        'votifier_response',
        'status'
    ];

    protected $casts = [
        'voted_at' => 'datetime',
        'next_vote_at' => 'datetime',
        'reward_sent' => 'boolean',
    ];

    public function server()
    {
        return $this->belongsTo(ServerListing::class, 'server_id', 'id');
    }

    public function canVoteAgain()
    {
        return $this->next_vote_at <= now();
    }

    public static function getTopVoters($serverId, $limit = 10)
    {
        return self::where('server_id', $serverId)
            ->select('username', DB::raw('COUNT(*) as vote_count'))
            ->where('voted_at', '>=', now()->subMonth())
            ->groupBy('username')
            ->orderByDesc('vote_count')
            ->limit($limit)
            ->get();
    }
}


