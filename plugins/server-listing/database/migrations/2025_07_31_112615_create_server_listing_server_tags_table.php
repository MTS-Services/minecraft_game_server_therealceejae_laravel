<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('server_listing_server_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('server_id')->nullable();
            $table->unsignedBigInteger('tag_id')->nullable();
            $table->foreign('server_id', 'tag_server_id')->references('id')->on('server_listing_servers')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('tag_id', 'server_tag_id')->references('id')->on('server_listing_tags')->nullOnDelete()->cascadeOnUpdate();
            $table->integer('position')->default(0);
            $table->timestamps();

            $table->index(['position', 'server_id', 'tag_id']);
        });

        // Attach tags to servers
        $serverIds = DB::table('server_listing_servers')->pluck('id')->toArray();
        $now = now();
        $tags = DB::table('server_listing_tags')->pluck('id')->toArray();
        $serverTags = [];
        foreach ($serverIds as $serverId) {
            $randomTags = collect($tags)->shuffle()->take(3)->values();
            foreach ($randomTags as $tagId) {
                $serverTags[] = [
                    'server_id' => $serverId,
                    'tag_id' => $tagId,
                    'position' => 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DB::table('server_listing_server_tags')->insert($serverTags);
    }

    public function down(): void
    {
        Schema::dropIfExists('server_listing_server_tags');
    }
};
