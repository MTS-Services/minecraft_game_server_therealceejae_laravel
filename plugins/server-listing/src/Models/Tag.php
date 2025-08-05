<?php

namespace Azuriom\Plugin\ServerListing\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tag extends Model
{
    use HasTablePrefix;
    protected $table = 'server_listing_tags';

    protected $fillable = [
        'name',
        'slug',
        'position',
        'is_active',
    ];

    protected const ACTIVE = true;
    protected const INACTIVE = false;

    protected $casts = [
        'is_active' => 'boolean',
        'position' => 'integer',
    ];

    protected $appends = [
        'status_list',
        'status_label',
        'status_bg',
    ];


    public function getStatusList(): array
    {
        return [
            self::ACTIVE => trans('server-listing::messages.status.active'),
            self::INACTIVE => trans('server-listing::messages.status.inactive'),
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->is_active ? $this->getStatusList()[self::ACTIVE] : $this->getStatusList()[self::INACTIVE];
    }

    public function getStatusBgAttribute(): string
    {
        return $this->is_active ? 'badge bg-success' : 'badge bg-danger';
    }
    public function scopeOrdered($query)
    {
        return $query->orderBy('position')->latest()->orderBy('name');
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopeInactive(Builder $query): void
    {
        $query->where('is_active', false);
    }
}
