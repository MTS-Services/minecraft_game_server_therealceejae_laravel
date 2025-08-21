<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('server_listing_vote_rewards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('server_id');
            $table->string('reward_name');
            $table->text('reward_description');
            $table->json('reward_commands'); // Array of commands to execute
            $table->integer('votes_required')->default(1);
            $table->tinyInteger('status')->default(1); // 1 for active, 0 for inactive
            $table->timestamps();

            $table->foreign('server_id', 'vote_reward_server')->references('id')->on('server_listing_servers')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vote_rewards');
    }
};
