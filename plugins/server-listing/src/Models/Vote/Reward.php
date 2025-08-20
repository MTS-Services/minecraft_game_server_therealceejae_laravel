<?php

namespace Azuriom\Plugin\ServerListing\Models\Vote;

use Azuriom\Models\Server;
use Azuriom\Models\Traits\HasImage;
use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\Loggable;
use Azuriom\Models\Traits\Searchable;
use Azuriom\Models\User;
use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @property int $id
 * @property string $name
 * @property string $image
 * @property float $chances
 * @property int|null $money
 * @property bool $need_online
 * @property string[] $commands
 * @property int[] $monthly_rewards
 * @property bool $single_server
 * @property bool $is_enabled
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\ServerListing\Models\Vote\Vote[] $votes
 * @property \Illuminate\Support\Collection|\Azuriom\Models\Server[] $servers
 *
 * @method static \Illuminate\Database\Eloquent\Builder enabled()
 */
class Reward extends Model
{
    use HasImage;
    use HasTablePrefix;
    use Loggable;
    use Searchable;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'server_listing_vote_';

    /**
     * The table name associated with the model.
     *
     * @var string
     */
    protected $table = 'server_listing_vote_rewards';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image',
        'chances',
        'money',
        'commands',
        'monthly_rewards',
        'need_online',
        'single_server',
        'is_enabled',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'commands' => 'array',
        'monthly_rewards' => 'array',
        'need_online' => 'boolean',
        'single_server' => 'boolean',
        'is_enabled' => 'boolean',
    ];

    /**
     * The attributes that can be used for search.
     *
     * @var array<int, string>
     */
    protected array $searchable = [
        'name',
    ];

    public function sites()
    {
        return $this->belongsToMany(Site::class, 'server_listing_vote_reward_site');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function servers()
    {
        return $this->belongsToMany(
            ServerListing::class,
            'server_listing_vote_reward_server',
            'reward_id',
            'server_id'
        );
    }



    public function dispatch(User|Vote $target, ?array $servers = null): void
    {
        $user = $target instanceof User ? $target : $target->user;
        $siteName = $target instanceof Vote ? $target->site->name : '?';

        if ($this->money > 0) {
            $user->addMoney($this->money);
        }

        $commands = $this->commands ?? [];

        if ($globalCommands = setting('server-listing.vote.commands')) {
            $commands = array_merge($commands, json_decode($globalCommands));
        }

        if (empty($commands)) {
            return;
        }

        $commands = array_map(fn(string $command) => str_replace([
            '{reward}',
            '{site}',
        ], [$this->name, $siteName], $command), $commands);

        foreach ($servers ?? $this->servers as $server) {
            $server->bridge()->sendCommands($commands, $user, $this->need_online);
        }
    }

    /**
     * Scope a query to only include enabled vote rewards.
     */
    public function scopeEnabled(Builder $query): void
    {
        $query->where('is_enabled', true);
    }
}
