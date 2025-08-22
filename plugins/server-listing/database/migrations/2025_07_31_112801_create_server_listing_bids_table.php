<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('server_listing_bids', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedBigInteger('server_listing_id')->nullable();
            $table->decimal('amount', 15, 2);
            $table->string('status')->default('pending'); // pending, win, paid, lose
            $table->timestamp('bidding_at');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('server_listing_id')->references('id')->on('server_listing_servers')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('server_listing_bids');
    }
};
