<?php

namespace Azuriom\Plugin\ServerListing\Models;

use Azuriom\Models\Traits\HasTablePrefix;
// use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Model;

use Azuriom\Plugin\ServerListing\Models\User;

use Azuriom\Plugin\Shop\Models\Concerns\Buyable;
use Azuriom\Plugin\Shop\Models\Concerns\IsBuyable;
use Azuriom\Plugin\Shop\Models\PaymentItem;

class ServerBid extends Model implements Buyable
{
    use HasTablePrefix, IsBuyable;

    protected $table = 'server_listing_bids';

    protected $fillable = [
        'user_id',
        'server_listing_id',
        'amount',
        'status',
        'bidding_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function serverListing()
    {
        return $this->belongsTo(ServerListing::class, 'server_listing_id')->withDefault();
    }

    public function getPrice(): float
    {
        return $this->amount;
    }

    public function getName(): string
    {
        return 'Bid for ' . $this->serverListing->name;
    }

    public function deliver(PaymentItem $item): void
    {
        $this->update(['status' => 'completed']);
    }
}
