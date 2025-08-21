<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('server_listing_server_favorites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('server_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('server_id', 'favorite_server')->references('id')->on('server_listing_servers')->cascadeOnDelete();
            $table->foreign('user_id', 'user_favorite_server')->references('id')->on('users')->cascadeOnDelete();

            $table->unique(['server_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('server_listing_server_favorites');
    }
};
