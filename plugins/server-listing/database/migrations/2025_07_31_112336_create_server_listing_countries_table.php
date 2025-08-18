<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Http; // Use Laravel's built-in HTTP client
use Illuminate\Support\Str;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('server_listing_countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->string('code', 20)->nullable();
            $table->integer('position')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'position']);
        });

        // Insert countries from an external API


        $response = Http::get('https://countriesnow.space/api/v0.1/countries');

        if ($response->successful()) {
            $countries = $response->json('data'); // Fixed here ✅
            $countriesToInsert = [];

            foreach ($countries as $country) {
                if (isset($country['country']) && isset($country['iso2'])) {
                    $name = $country['country'];
                    $countriesToInsert[] = [
                        'name' => $name,
                        'slug' => Str::slug($name),
                        'code' => $country['iso2'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            foreach (array_chunk($countriesToInsert, 100) as $chunk) {
                DB::table('server_listing_countries')->insert($chunk);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_listing_countries');
    }
};
