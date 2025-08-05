<?php

namespace Azuriom\Plugin\ServerListing\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServerTag extends Model
{
    use HasTablePrefix;
    protected $table = 'server_listing_tags';

    protected $fillable = [
        'server_id',
        'tag_id',
        'position',
    ];

    protected $casts = [
        'position' => 'integer',
    ];

    public function server(): BelongsTo
    {
        return $this->belongsTo(ServerListing::class, 'server_id');
    }

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
