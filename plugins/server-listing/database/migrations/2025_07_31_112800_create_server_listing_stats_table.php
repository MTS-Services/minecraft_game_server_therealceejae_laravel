<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('server_listing_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('server_id')->constrained('server_listing_servers')->onDelete('cascade');
            $table->date('date');
            $table->integer('unique_votes')->default(0);
            $table->integer('total_votes')->default(0);
            $table->integer('avg_players')->default(0);
            $table->integer('max_players_reached')->default(0);
            $table->decimal('uptime_percentage', 5, 2)->default(0.00);
            $table->timestamps();

            $table->unique(['server_id', 'date']);
            $table->index(['server_id', 'date']);
            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('server_listing_stats');
    }
};
