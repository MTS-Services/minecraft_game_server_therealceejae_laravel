<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('server_listing_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('server_id')->constrained('server_listing_servers')->onDelete('cascade');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->string('ip_address', 45);
            $table->timestamp('voted_at');
            $table->timestamp('expires_at');
            $table->timestamps();

            $table->index(['server_id', 'voted_at']);
            $table->index(['user_id', 'expires_at']);
            $table->index(['ip_address', 'expires_at']);
            $table->index('voted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('server_listing_votes');
    }
};
