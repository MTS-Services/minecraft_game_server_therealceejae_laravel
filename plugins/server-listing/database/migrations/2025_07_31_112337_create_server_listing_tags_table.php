<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('server_listing_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->integer('position')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'position']);
        });

        // Insert default tags
        DB::table('server_listing_tags')->insert([
            ['name' => 'Adult', 'slug' => 'adult', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Adventure', 'slug' => 'adventure', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Agrarian Skies', 'slug' => 'agrarian-skies', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'All The Mods', 'slug' => 'all-the-mods', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Among Us', 'slug' => 'among-us', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Anarchy', 'slug' => 'anarchy', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Arena', 'slug' => 'arena', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Attack Of The B-Team', 'slug' => 'attack-of-the-b-team', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Battle Royale', 'slug' => 'battle-royale', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'BedWars', 'slug' => 'bedwars', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'BetterMC', 'slug' => 'bettermc', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bitcoin', 'slug' => 'bitcoin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Blocks Vs Zombies', 'slug' => 'blocks-vs-zombies', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bukkit', 'slug' => 'bukkit', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'BungeeCord', 'slug' => 'bungeecord', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Capture The Flag', 'slug' => 'capture-the-flag', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Casual', 'slug' => 'casual', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Challenge', 'slug' => 'challenge', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'City', 'slug' => 'city', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cobblemon', 'slug' => 'cobblemon', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cops And Robbers', 'slug' => 'cops-and-robbers', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Creative', 'slug' => 'creative', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cross-Play', 'slug' => 'cross-play', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cryptocurrency', 'slug' => 'cryptocurrency', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dawncraft', 'slug' => 'dawncraft', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'direwolf20', 'slug' => 'direwolf20', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Discord', 'slug' => 'discord', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Drug', 'slug' => 'drug', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Earth', 'slug' => 'earth', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Economy', 'slug' => 'economy', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'EggWars', 'slug' => 'eggwars', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Events', 'slug' => 'events', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Faction', 'slug' => 'faction', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Feed The Beast', 'slug' => 'feed-the-beast', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'FTB Infinity Evolved', 'slug' => 'ftb-infinity-evolved', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'FTB Revelation', 'slug' => 'ftb-revelation', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'GTA', 'slug' => 'gta', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hardcore', 'slug' => 'hardcore', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hardcore Factions', 'slug' => 'hardcore-factions', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hexxit', 'slug' => 'hexxit', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hunger Games', 'slug' => 'hunger-games', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jobs', 'slug' => 'jobs', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'KitPvP', 'slug' => 'kitpvp', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Land Claim', 'slug' => 'land-claim', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'LGBT', 'slug' => 'lgbt', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'LifeSteal', 'slug' => 'lifesteal', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lucky Block', 'slug' => 'lucky-block', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Madpack', 'slug' => 'madpack', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Magic World', 'slug' => 'magic-world', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Manhunt', 'slug' => 'manhunt', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'McMMO', 'slug' => 'mcmmo', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'MineZ', 'slug' => 'minez', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Minigames', 'slug' => 'minigames', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Movecraft', 'slug' => 'movecraft', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'OneBlock', 'slug' => 'oneblock', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Paper', 'slug' => 'paper', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Parkour', 'slug' => 'parkour', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pirate', 'slug' => 'pirate', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pixelmon', 'slug' => 'pixelmon', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pixelmon Reforged', 'slug' => 'pixelmon-reforged', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pixelspark', 'slug' => 'pixelspark', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pokemon', 'slug' => 'pokemon', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Practice', 'slug' => 'practice', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Prison', 'slug' => 'prison', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Project Ozone', 'slug' => 'project-ozone', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PvE', 'slug' => 'pve', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PvP', 'slug' => 'pvp', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Raiding', 'slug' => 'raiding', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ranks', 'slug' => 'ranks', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Realms', 'slug' => 'realms', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'RLCraft', 'slug' => 'rlcraft', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Roleplay', 'slug' => 'roleplay', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sevtech Ages', 'slug' => 'sevtech-ages', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sky Factory', 'slug' => 'sky-factory', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Skyblock', 'slug' => 'skyblock', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Skygrid', 'slug' => 'skygrid', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Skywars', 'slug' => 'skywars', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'SlimeFun', 'slug' => 'slimefun', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'SMP', 'slug' => 'smp', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Spigot', 'slug' => 'spigot', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'StoneBlock', 'slug' => 'stoneblock', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Survival', 'slug' => 'survival', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Survival Games', 'slug' => 'survival-games', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tekkit', 'slug' => 'tekkit', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Towny', 'slug' => 'towny', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Vanilla', 'slug' => 'vanilla', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Vehicle', 'slug' => 'vehicle', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'War', 'slug' => 'war', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Waterfall', 'slug' => 'waterfall', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Whitelist', 'slug' => 'whitelist', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Zombie', 'slug' => 'zombie', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('server_listing_tags');
    }
};
