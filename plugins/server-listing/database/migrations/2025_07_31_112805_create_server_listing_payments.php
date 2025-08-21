<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('server_listing_server_favorites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('server_id');
            $table->decimal('price', 10, 2);
            $table->string('currency');
            $table->string('gateway_type');
            $table->string('status');
            $table->string('transaction_id')->nullable();
            $table->timestamps();

            $table->foreign('server_id', 'user_servers')->references('id')->on('server_listing_servers')->cascadeOnDelete();
            $table->foreign('user_id', 'server_users')->references('id')->on('users')->cascadeOnDelete();

            $table->unique(['server_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('server_listing_server_favorites');
    }
};
