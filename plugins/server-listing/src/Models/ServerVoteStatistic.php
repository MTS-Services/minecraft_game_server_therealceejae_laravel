<?php

namespace Azuriom\Plugin\ServerListing\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class ServerVoteStatistic extends Model
{
    use HasTablePrefix;
    protected $table = 'server_listing_vote_statistics';

    protected $fillable = [
        'server_id',
        'date',
        'total_votes',
        'unique_voters'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function server(): BelongsTo
    {
        return $this->belongsTo(ServerListing::class, 'server_id', 'id');
    }

    public static function updateStats($serverId, $date = null)
    {
        $date = $date ?: now()->toDateString();

        $stats = ServerVote::where('server_id', $serverId)->where('status', 1)
            ->whereDate('voted_at', $date)
            ->selectRaw('COUNT(*) as total_votes, COUNT(DISTINCT username) as unique_voters')
            ->first();

        return self::updateOrCreate(
            ['server_id' => $serverId, 'date' => $date],
            [
                'total_votes' => $stats->total_votes,
                'unique_voters' => $stats->unique_voters
            ]
        );
    }
}


