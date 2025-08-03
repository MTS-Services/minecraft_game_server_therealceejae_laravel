<?php

namespace Azuriom\Plugin\ServerListing\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServerVote extends Model
{
    use HasTablePrefix;
    protected $table = 'server_listing_votes';

    protected $fillable = [
        'server_id',
        'user_id',
        'ip_address',
        'voted_at',
        'expires_at',
    ];

    protected $casts = [
        'voted_at' => 'datetime',
        'expires_at' => 'datetime',
        'server_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function server(): BelongsTo
    {
        return $this->belongsTo(ServerListing::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeValid($query)
    {
        return $query->where('expires_at', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    public function scopeForUser($query, ?User $user = null)
    {
        if ($user) {
            return $query->where('user_id', $user->id);
        }

        return $query->where('ip_address', request()->ip());
    }

    public function scopeToday($query)
    {
        return $query->whereDate('voted_at', today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('voted_at', now()->month)
            ->whereYear('voted_at', now()->year);
    }
}
