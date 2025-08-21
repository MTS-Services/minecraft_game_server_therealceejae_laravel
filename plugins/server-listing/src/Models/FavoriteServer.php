<?php

namespace Azuriom\Plugin\ServerListing\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FavoriteServer extends Model
{
    use HasTablePrefix;
    protected $table = 'server_listing_server_favorites';

    protected $fillable = [
        'server_id',
        'user_id',
    ];

    public function server(): BelongsTo
    {
        return $this->belongsTo(ServerListing::class, 'server_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
