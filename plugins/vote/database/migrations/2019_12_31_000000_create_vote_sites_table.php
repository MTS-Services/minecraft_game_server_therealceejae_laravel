<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('vote_votes');
        Schema::dropIfExists('vote_reward_site');
        Schema::dropIfExists('vote_rewards');
        Schema::dropIfExists('vote_sites');

        Schema::create('vote_sites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('url');
            $table->unsignedInteger('vote_delay');
            $table->string('verification_key')->nullable();
            $table->boolean('has_verification')->default(true);
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vote_sites');
    }
};
