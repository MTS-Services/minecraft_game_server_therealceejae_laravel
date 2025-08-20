<?php

namespace Azuriom\Plugin\ServerListing\Models\Vote;

use Azuriom\Models\Server;
use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\Searchable;
use Azuriom\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property int $user_id
 * @property int $server_id
 * @property int $site_id
 * @property int $reward_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Azuriom\Models\User $user
 * @property \Azuriom\Models\Server $server
 * @property \Azuriom\Plugin\ServerListing\Models\Vote\Site|null $site
 * @property \Azuriom\Plugin\ServerListing\Models\Vote\Reward|null $reward
 */
class Vote extends Model
{
    use HasTablePrefix;
    use Searchable;


    /**
     * The table name associated with the model.
     *
     * @var string
     */
    protected $table = 'server_listing_vote_votes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'server_id',
        'reward_id',
        'site_id',
    ];

    /**
     * The attributes that can be used for search.
     *
     * @var array<int, string>
     */
    protected array $searchable = [
        'site.*',
        'reward.*',
        'user.name',
        'server.name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }

    public static function getTopVoters(DateTime $from, ?DateTime $to = null)
    {
        $votes = static::getRawTopVoters($from, $to);

        $users = User::findMany($votes->pluck('user_id'))->keyBy('id');

        return $votes->mapWithKeys(function ($vote, $position) use ($users) {
            return [
                $position + 1 => (object) [
                    'user' => $users->get($vote->user_id),
                    'votes' => $vote->total,
                    'position' => $position + 1,
                ],
            ];
        });
    }

    public static function getRawTopVoters(DateTime $from, ?DateTime $to = null, ?int $max = null)
    {
        return self::select(['user_id', DB::raw('count(*) as total')])
            ->whereBetween('created_at', [$from, $to ?? now()])
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->take($max ?? setting('server-listing.vote.top-players-count', 10))
            ->get();
    }
}
