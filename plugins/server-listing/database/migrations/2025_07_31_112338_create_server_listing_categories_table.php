<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('server_listing_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('color', 7)->default('#3B82F6');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });

        // Insert default categories
        DB::table('server_listing_categories')->insert([
            [
                'name' => 'Survival',
                'slug' => 'survival',
                'description' => 'Classic Minecraft survival servers',
                'icon' => 'fas fa-tree',
                'color' => '#10B981',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Creative',
                'slug' => 'creative',
                'description' => 'Build anything in creative mode',
                'icon' => 'fas fa-cube',
                'color' => '#F59E0B',
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PvP',
                'slug' => 'pvp',
                'description' => 'Player vs Player combat servers',
                'icon' => 'fas fa-sword',
                'color' => '#EF4444',
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Minigames',
                'slug' => 'minigames',
                'description' => 'Fun minigames and competitions',
                'icon' => 'fas fa-gamepad',
                'color' => '#8B5CF6',
                'sort_order' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Modded',
                'slug' => 'modded',
                'description' => 'Servers with mods and custom content',
                'icon' => 'fas fa-cogs',
                'color' => '#06B6D4',
                'sort_order' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Economy',
                'slug' => 'economy',
                'description' => 'Trade and economy focused servers',
                'icon' => 'fas fa-coins',
                'color' => '#F59E0B',
                'sort_order' => 6,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('server_listing_categories');
    }
};
