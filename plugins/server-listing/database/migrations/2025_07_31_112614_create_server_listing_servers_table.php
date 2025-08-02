<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('server_listing_servers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('category_id')->constrained('server_listing_categories')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->text('description');
            $table->string('server_ip');
            $table->integer('server_port')->default(25565);
            $table->string('website_url')->nullable();
            $table->string('discord_url')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('logo_image')->nullable();
            $table->string('version', 50);
            $table->integer('max_players')->default(100);
            $table->integer('current_players')->default(0);
            $table->boolean('is_online')->default(false);
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->json('tags')->nullable();
            $table->integer('vote_count')->default(0);
            $table->integer('total_votes')->default(0);
            $table->timestamp('last_ping')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_approved', 'is_featured', 'vote_count']);
            $table->index(['category_id', 'is_approved']);
            $table->index(['is_online', 'is_approved']);
            $table->index('user_id');
            $table->fullText(['name', 'description']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('server_listing_servers');
    }
};
