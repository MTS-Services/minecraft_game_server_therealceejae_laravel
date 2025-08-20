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
        Schema::create('server_listing_vote_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('server_id');
            $table->unsignedInteger('site_id');
            $table->unsignedInteger('reward_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('server_id', 'server_id')->references('id')->on('server_listing_servers')->cascadeOnDelete();
            $table->foreign('site_id')->references('id')->on('server_listing_vote_sites')->cascadeOnDelete();
            $table->foreign('reward_id')->references('id')->on('server_listing_vote_rewards')->cascadeOnDelete();

            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_listing_vote_votes');
    }
};
