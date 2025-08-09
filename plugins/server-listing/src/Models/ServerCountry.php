<?php

namespace Azuriom\Plugin\ServerListing\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServerCountry extends Model
{
    use HasTablePrefix;
    protected $table = 'server_listing_countries';

    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'code',
        'position',
    ];

    protected $casts = [
        'position' => 'integer',
        'is_active' => 'boolean',
    ];

    public function servers(): HasMany
    {
        return $this->hasMany(ServerListing::class, 'country_id');
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopeInactive(Builder $query): void
    {
        $query->where('is_active', false);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('position')->latest()->orderBy('name');
    }
}
