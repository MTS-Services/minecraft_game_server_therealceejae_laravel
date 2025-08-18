<?php

namespace Azuriom\Plugin\ServerListing\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasTablePrefix;

    protected $fillable = [
        'user_id',
        'server_listing_id',
        'amount',
        'bidding_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function serverListing()
    {
        return $this->belongsTo(ServerListing::class, 'server_listing_id')->withDefault();
    }
}