<?php

namespace Azuriom\Plugin\ServerListing\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServerStats extends Model
{
    use HasTablePrefix;
    protected $table = 'server_listing_stats';

    protected $fillable = [
        'server_id',
        'date',
        'unique_votes',
        'total_votes',
        'avg_players',
        'max_players_reached',
        'uptime_percentage',
    ];

    protected $casts = [
        'date' => 'date',
        'server_id' => 'integer',
        'unique_votes' => 'integer',
        'total_votes' => 'integer',
        'avg_players' => 'integer',
        'max_players_reached' => 'integer',
        'uptime_percentage' => 'decimal:2',
    ];

    public function server(): BelongsTo
    {
        return $this->belongsTo(ServerListing::class);
    }

    public function scopeForPeriod($query, $startDate, $endDate = null)
    {
        $endDate = $endDate ?? now();

        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereBetween('date', [
            now()->startOfMonth(),
            now()->endOfMonth()
        ]);
    }

    public function scopeLastDays($query, $days = 7)
    {
        return $query->whereBetween('date', [
            now()->subDays($days),
            now()
        ]);
    }

    public static function createOrUpdateDaily(ServerListing $server, array $data = [])
    {
        return static::updateOrCreate(
            [
                'server_id' => $server->id,
                'date' => today(),
            ],
            array_merge([
                'unique_votes' => $server->votes()->today()->distinct('user_id')->count(),
                'total_votes' => $server->votes()->today()->count(),
                'avg_players' => $server->current_players,
                'max_players_reached' => $server->current_players,
                'uptime_percentage' => $server->is_online ? 100 : 0,
            ], $data)
        );
    }
}
