<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('server_listing_vote_statistics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('server_id');
            $table->date('date');
            $table->integer('total_votes')->default(0);
            $table->integer('unique_voters')->default(0);
            $table->timestamps();

            $table->foreign('server_id', 'vote_statistics_server')->references('id')->on('server_listing_servers')->cascadeOnDelete();

            $table->unique(['server_id', 'date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('server_listing_vote_statistics');
    }
};
