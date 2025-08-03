<?php

namespace Azuriom\Plugin\ServerListing\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class ServerListing extends Model
{
    use HasTablePrefix;
    protected $table = 'server_listing_servers';

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'slug',
        'description',
        'server_ip',
        'server_port',
        'website_url',
        'discord_url',
        'banner_image',
        'logo_image',
        'version',
        'max_players',
        'current_players',
        'is_online',
        'is_premium',
        'is_featured',
        'is_approved',
        'tags',
        'vote_count',
        'total_votes',
        'last_ping',
        'sort_order',
    ];

    protected $appends = [
        'featured_label',
        'featured_bg',
        'logo_image_url',
        'banner_image_url',
        'online_label',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_online' => 'boolean',
        'is_premium' => 'boolean',
        'is_featured' => 'boolean',
        'is_approved' => 'boolean',
        'last_ping' => 'datetime',
        'server_port' => 'integer',
        'max_players' => 'integer',
        'current_players' => 'integer',
        'vote_count' => 'integer',
        'total_votes' => 'integer',
        'sort_order' => 'integer',
    ];

    public const FEATURED = 1;
    public const NOT_FEATURED = 0;

    public function getFeaturedList(): array
    {
        return [
            self::FEATURED => 'Featured',
            self::NOT_FEATURED => 'Not Featured',
        ];

    }

    public function getLogoImageUrlAttribute(): string
    {
        return $this->logo_image ? Storage::url($this->logo_image) : asset('themes/default/img/default-logo.png');
    }

    public function getBannerImageUrlAttribute(): string
    {
        return $this->banner_image ? Storage::url($this->banner_image) : asset('themes/default/img/default-banner.png');
    }

    public function getFeaturedLabelAttribute(): string
    {
        return $this->is_featured ? $this->getFeaturedList()[self::FEATURED] : $this->getFeaturedList()[self::NOT_FEATURED];
    }

    public function getFeaturedBgAttribute(): string
    {
        return $this->is_featured ? 'badge bg-success' : 'badge bg-danger';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServerCategory::class, 'category_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(ServerVote::class);
    }

    public function stats(): HasMany
    {
        return $this->hasMany(ServerStats::class);
    }

    public function getStatusColorAttribute(): string
    {
        return $this->is_online ? 'text-green-400' : 'text-red-400';
    }

    public function getStatusTextAttribute(): string
    {
        return $this->is_online ? 'Online' : 'Offline';
    }

    public function getFullAddressAttribute(): string
    {
        return "{$this->server_ip}:{$this->server_port}";
    }

    public function getPlayersPercentageAttribute(): float
    {
        if ($this->max_players === 0) {
            return 0;
        }

        return min(100, ($this->current_players / $this->max_players) * 100);
    }

    public function canUserVote(?User $user = null): bool
    {
        if ($user) {
            return !$this->votes()
                ->where('user_id', $user->id)
                ->where('expires_at', '>', now())
                ->exists();
        }

        $ip = request()->ip();
        return !$this->votes()
            ->where('ip_address', $ip)
            ->where('expires_at', '>', now())
            ->exists();
    }

    public function getUserNextVoteTime(?User $user = null): ?string
    {
        $vote = null;

        if ($user) {
            $vote = $this->votes()
                ->where('user_id', $user->id)
                ->where('expires_at', '>', now())
                ->first();
        } else {
            $ip = request()->ip();
            $vote = $this->votes()
                ->where('ip_address', $ip)
                ->where('expires_at', '>', now())
                ->first();
        }

        return $vote ? $vote->expires_at->format('Y-m-d H:i:s') : null;
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }
    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    public function scopeOnline($query)
    {
        return $query->where('is_online', true);
    }
    public function scopeOffline($query)
    {
        return $query->where('is_online', false);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
    public function scopeNotFeatured($query)
    {
        return $query->where('is_featured', false);
    }

    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }
    public function scopeNotPremium($query)
    {
        return $query->where('is_premium', false);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('server_ip', 'like', "%{$search}%")
                ->orWhereJsonContains('tags', $search);
        });
    }

    public function scopeOrderByPopularity($query)
    {
        return $query->orderByDesc('vote_count')
            ->orderByDesc('current_players')
            ->orderByDesc('total_votes');
    }

    public function scopeOrderByRank($query)
    {
        return $query->orderByDesc('is_featured')
            ->orderByDesc('is_premium')
            ->orderByDesc('vote_count')
            ->orderBy('sort_order')
            ->orderBy('name');
    }

    public function getOnlineLabelAttribute(): string
    {
        return $this->is_online ? 'Online' : 'Offline';
    }

}
