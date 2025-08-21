<?php

namespace Azuriom\Plugin\ServerListing\Models;

use Azuriom\Models\User as BaseUser;
use Azuriom\Plugin\ServerListing\Models\ServerBid;

class User extends BaseUser
{
    public function bids()
    {
        return $this->hasMany(ServerBid::class, 'user_id', 'id');
    }

    public static function ofUser(BaseUser $baseUser): self
    {
        return (new self())->newFromBuilder($baseUser->getAttributes());
    }
}
