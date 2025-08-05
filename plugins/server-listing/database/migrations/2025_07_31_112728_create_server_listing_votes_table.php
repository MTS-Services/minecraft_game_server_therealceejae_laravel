<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('server_listing_votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('server_id')->nullable();
            $table->foreign('server_id', 'vote_server_id')->references('id')->on('server_listing_servers')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->string('ip_address', 45);
            $table->timestamp('voted_at');
            $table->timestamp('expires_at')->nullable();
            $table->integer('position')->default(0);
            $table->timestamps();

            $table->index(
                ['server_id', 'voted_at', 'expires_at', 'user_id', 'ip_address', 'position'],
                'server_votes_main_index'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('server_listing_votes');
    }
};
