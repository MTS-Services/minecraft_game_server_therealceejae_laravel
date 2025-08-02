<?php

namespace Azuriom\Plugin\ServerListing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServerCategory extends Model
{
    protected $table = 'server_listing_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function servers(): HasMany
    {
        return $this->hasMany(ServerListing::class, 'category_id');
    }

    public function activeServers(): HasMany
    {
        return $this->hasMany(ServerListing::class, 'category_id')
            ->where('is_approved', true)
            ->where('is_active', true);
    }

    public function getServerCountAttribute(): int
    {
        return $this->activeServers()->count();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
