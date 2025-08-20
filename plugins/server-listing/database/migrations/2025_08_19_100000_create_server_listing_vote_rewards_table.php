<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('server_listing_vote_rewards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('chances');
            $table->decimal('money')->default(0);
            $table->text('commands')->nullable();
            $table->boolean('need_online')->default(false);
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });

        Schema::create('server_listing_vote_reward_server', function (Blueprint $table) {
            $table->unsignedInteger('reward_id');
            $table->unsignedBigInteger('server_id');

            $table->foreign('reward_id', 'vote_reward_id')->references('id')->on('server_listing_vote_rewards')->cascadeOnDelete();
            $table->foreign('server_id', 'reward_server_id')->references('id')->on('server_listing_servers')->cascadeOnDelete()->cascadeOnUpdate();

            $table->unique(['reward_id', 'server_id']);
        });

        Schema::create('server_listing_vote_reward_site', function (Blueprint $table) {
            $table->unsignedInteger('reward_id');
            $table->unsignedInteger('site_id');

            $table->foreign('reward_id', 'reward_id')->references('id')->on('server_listing_vote_rewards')->cascadeOnDelete();
            $table->foreign('site_id', 'site_id')->references('id')->on('server_listing_vote_sites')->cascadeOnDelete();

            $table->unique(['reward_id', 'site_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_listing_vote_rewards');
        Schema::dropIfExists('server_listing_vote_reward_server');
        Schema::dropIfExists('server_listing_vote_reward_site');
    }
};
