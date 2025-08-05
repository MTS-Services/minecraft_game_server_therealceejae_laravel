<?php

namespace Azuriom\Plugin\ServerListing\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class ServerListing extends Model
{
    use HasTablePrefix;
    protected $table = 'server_listing_servers';

    protected $fillable = [
        'user_id',
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
        'vote_count',
        'total_votes',
        'last_ping',
        'position',
        'country_id',
        'server_rank',
        'youtube_video',
    ];

    protected $appends = [
        'featured_label',
        'featured_bg',
        'logo_image_url',
        'banner_image_url',
        'online_label',
        'full_address',
        'premium_label',
        'online_bg',
        'approved_label',
        'approved_bg',
        'premium_bg',
    ];

    protected $casts = [
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
        'position' => 'integer',
        'server_rank' => 'integer',
    ];

    public const FEATURED = 1;
    public const NOT_FEATURED = 0;

    public function getFeaturedList(): array
    {
        return [
            self::FEATURED => trans('server-listing::messages.status.featured'),
            self::NOT_FEATURED => trans('server-listing::messages.status.not_featured'),
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

    public function votes(): HasMany
    {
        return $this->hasMany(ServerVote::class);
    }

    public function stats(): HasMany
    {
        return $this->hasMany(ServerStats::class);
    }
    public function getFullAddressAttribute(): string
    {
        return $this->server_port ? "{$this->server_ip}:{$this->server_port}" : $this->server_ip . ':25565';
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

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('server_ip', 'like', "%{$search}%");

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
            ->orderBy('position')
            ->orderBy('name');
    }

    public function getOnlineLabelAttribute(): string
    {
        return $this->is_online ? 'Online' : 'Offline';
    }
    public function getPremiumLabelAttribute(): string
    {
        return $this->is_premium ? 'Premium' : 'Free';
    }
    public function getOnlineBgAttribute(): string
    {
        return $this->is_online ? 'badge bg-success' : 'badge bg-secondary';
    }
    public function getPremiumBgAttribute(): string
    {
        return $this->is_premium ? 'badge bg-success' : 'badge bg-info';
    }

    public function getApprovedLabelAttribute(): string
    {
        return $this->is_approved ? 'Approved' : 'Pending';
    }
    public function getApprovedBgAttribute(): string
    {
        return $this->is_approved ? 'badge bg-success' : 'badge bg-primary';
    }

    public function serverTags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'server_listing_server_tags', 'server_id', 'tag_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('is_featured')->orderBy('is_premium')->orderBy('position')->latest()->orderBy('name');
    }
    public function country(): BelongsTo
    {
        return $this->belongsTo(ServerCountry::class, 'country_id');
    }

}
