<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('server_listing_server_favorites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id');
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->timestamp('expires_at')->nullable();

            $table->foreign('payment_id', 'server_listing_payments')->references('id')->on('server_listing_payments')->cascadeOnDelete();
            $table->foreign('user_id', 'server_users')->references('id')->on('users')->cascadeOnDelete();

            $table->unique(['payment_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('server_listing_server_favorites');
    }
};
