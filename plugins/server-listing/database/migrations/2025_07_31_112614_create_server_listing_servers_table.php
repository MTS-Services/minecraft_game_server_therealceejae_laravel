@ -1,59 +0,0 @@
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('server_listing_servers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('country_id', 'server_country_id')->references('id')->on('server_listing_countries')->nullOnDelete()->cascadeOnUpdate();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->text('motd')->nullable();
            $table->text('description');
            $table->string('server_ip')->nullable();
            $table->string('server_port')->nullable();
            $table->string('website_url')->nullable();
            $table->string('discord_url')->nullable();
            $table->string('discord_server_id')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('logo_image')->nullable();
            $table->string('minecraft_version', 50);
            $table->string('support_email', 50)->nullable();
            $table->string('votifier_host')->nullable();
            $table->string('votifier_port')->nullable();
            $table->text('votifier_public_key')->nullable();
            $table->text('teamspeak_server_api_key')->nullable();

            $table->integer('max_players')->default(100);
            $table->integer('current_players')->default(0);
            $table->boolean('is_bedrock_supported')->default(false);
            $table->boolean('is_online')->default(false);
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->boolean('hide_voters')->default(false);
            $table->boolean('hide_players_list')->default(false);
            $table->boolean('block_ping')->default(false);
            $table->boolean('block_version_detection')->default(false);
            $table->boolean('terms_accepted')->default(false);
            $table->integer('vote_count')->default(0);
            $table->integer('total_votes')->default(0);
            $table->timestamp('last_ping')->nullable();
            $table->string('youtube_video')->nullable();
            $table->bigInteger('server_rank')->default(0);
            $table->integer('position')->default(0);
            $table->timestamps();

            $table->index(
                [
                    'is_approved',
                    'is_featured',
                    'is_premium',
                    'is_online',
                    'position',
                    'user_id',
                    'server_ip',
                    'server_port',
                    'website_url',
                    'country_id',

                ],
                'server_listing_servers_long_index' // Use a shorter, more descriptive name
            );
            $table->fullText(['name', 'description']);
        });


        $now = now();
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@dev.com',
                'password' => Hash::make('admin@dev.com'),
                'game_id' => '1d48a98741ab3104b55e4225f1db5c77',
                'email_verified_at' => $now,
                'last_login_ip' => '127.0.0.1',
                'password_changed_at' => $now,
                'last_login_at' => $now,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'user',
                'email' => 'user@dev.com',
                'last_login_ip' => '127.0.0.1',
                'password_changed_at' => $now,
                'last_login_at' => $now,
                'password' => Hash::make('user@dev.com'),
                'game_id' => '1d48a98741ab3104b55e4225f1db5c76',
                'email_verified_at' => $now,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $generateServers = function ($count, $attributes) use ($now) {
            $servers = [];

            for ($i = 1; $i <= $count; $i++) {
                $name = 'Bangladesh Craft ' . Str::random(6);
                $servers[] = array_merge([
                    'user_id' => 2,
                    'country_id' => $i,
                    'name' => $name,
                    'slug' => Str::slug($name) . '-' . Str::random(4),
                    'description' => 'This is a sample description for ' . $name,
                    'motd' => 'This is a sample MOTD for ' . $name,
                    'server_ip' => 'BangladeshCraft.aternos.me',
                    'server_port' => '25565',
                    'website_url' => 'https://' . $name . '.example.com',
                    'discord_url' => 'https://discord.gg/' . Str::random(6),
                    'discord_server_id' => '123456789012345678',
                    'banner_image' => 'https://placehold.co/400x70',
                    'logo_image' => 'https://placehold.co/60',
                    'minecraft_version' => '1.18.2',
                    'support_email' => $name . '@example.com',
                    'votifier_host' => '127.0.0.1',
                    'votifier_port' => '25565',
                    'votifier_public_key' => 'public_key',
                    'teamspeak_server_api_key' => 'teamspeak_api_key',
                    'max_players' => rand(1, 1000),
                    'current_players' => rand(0, 1000),
                    'is_online' => rand(0, 1),
                    'server_rank' => rand(1, 1000),
                    'is_premium' => rand(0, 1),
                    'is_featured' => rand(0, 1),
                    'is_approved' => rand(0, 1),
                    'hide_voters' => rand(0, 1),
                    'hide_players_list' => rand(0, 1),
                    'block_ping' => rand(0, 1),
                    'block_version_detection' => rand(0, 1),
                    'terms_accepted' => rand(0, 1),
                    'vote_count' => rand(0, 100),
                    'total_votes' => rand(0, 100),
                    'last_ping' => $now,
                    'youtube_video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'position' => rand(0, 100),
                    'created_at' => $now,
                    'updated_at' => $now,
                ], $attributes);
            }

            return $servers;
        };

        // Insert servers
        $featuredPremiumServers = $generateServers(10, ['is_featured' => true, 'is_premium' => true]);
        $premiumServers = $generateServers(15, ['is_featured' => false, 'is_premium' => true]);
        $regularServers = $generateServers(15, ['is_featured' => false, 'is_premium' => false]);

        $allServers = array_merge($featuredPremiumServers, $premiumServers, $regularServers);

        DB::table('server_listing_servers')->insert($allServers);
    }

    public function down(): void
    {
        Schema::dropIfExists('server_listing_servers');
    }
};
