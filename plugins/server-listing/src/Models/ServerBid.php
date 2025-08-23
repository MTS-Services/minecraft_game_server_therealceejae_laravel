<?php

namespace Azuriom\Plugin\ServerListing\Models;

use Azuriom\Models\Traits\HasTablePrefix;
// use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Model;

use Azuriom\Plugin\ServerListing\Models\User;

use Azuriom\Plugin\Shop\Models\Concerns\Buyable;
use Azuriom\Plugin\Shop\Models\Concerns\IsBuyable;
use Azuriom\Plugin\Shop\Models\PaymentItem;
use Azuriom\Plugin\Shop\Models\Payment;

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

    protected $casts = [
        'bidding_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if ($model->status === 'paid' && $model->serverListing) {
                $model->serverListing->update(['is_premium' => true, 'is_featured' => true]);
            }
        });

        // When updating
        static::updating(function ($model) {
            if ($model->isDirty('status') && $model->status === 'paid' && $model->bid) {
                $model->serverListing->update(['is_premium' => true, 'is_featured' => true]);
            }
        });
    }

    public function getDescription(): string
    {
        return 'Bid for ' . $this->serverListing->name;
    }


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

    public function payments()
    {
        return $this->hasMany(Payment::class, 'bid_id', 'id')->scopes(['notPending', 'withRealMoney']);
    }

    public function deliver(PaymentItem $item): void
    {
        $this->update(['status' => 'completed']);
    }


    public static function getStatusList(): array
    {
        return [
            'pending' => 'Pending',
            'win' => 'Win',
            'paid' => 'Paid',
            'rejected' => 'Rejected',
        ];
    }
}
