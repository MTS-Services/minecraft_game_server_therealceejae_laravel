<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('server_listing_id')->index();
            $table->decimal('amount', 8, 2);
            $table->date('bidding_at')->now();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('server_listing_id')->references('id')->on('server_listings')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bids');
    }
};
