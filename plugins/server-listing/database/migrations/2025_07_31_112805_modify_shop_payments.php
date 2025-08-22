<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('shop_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('server_id')->nullable()->after('user_id');
            $table->foreign('server_id', 'user_servers')->references('id')->on('server_listing_servers')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('shop_payments', function (Blueprint $table) {
            $table->dropForeign('user_servers');
            $table->dropColumn('server_id');
        });
    }
};
