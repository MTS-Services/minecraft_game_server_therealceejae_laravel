<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('shop_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('bid_id')->nullable()->after('user_id');
            $table->foreign('bid_id', 'user_bids')->references('id')->on('server_listing_bids')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('shop_payments', function (Blueprint $table) {
            $table->dropForeign('user_bids');
            $table->dropColumn('bid_id');
        });
    }
};
