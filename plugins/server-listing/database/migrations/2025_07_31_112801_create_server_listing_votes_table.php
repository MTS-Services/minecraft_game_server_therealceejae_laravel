<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('server_listing_votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('server_id');
            $table->string('username');
            $table->string('ip_address');
            $table->timestamp('voted_at');
            $table->timestamp('next_vote_at');
            $table->boolean('reward_sent')->default(false);
            $table->text('votifier_response')->nullable();
            $table->tinyInteger('status')->default(0); // pending, success, failed
            $table->timestamps();

            $table->foreign('server_id', 'vote_server')->references('id')->on('server_listing_servers')->cascadeOnDelete();

            $table->index(['server_id', 'voted_at']);
            $table->index(['username', 'server_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('server_listing_votes');
    }
};
