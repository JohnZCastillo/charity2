<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_contents', function (Blueprint $table) {
            // Change hero_image from string to json
            $table->json('hero_images')->nullable()->after('system_logo');

            // Drop the old single hero_image if it exists
            if (Schema::hasColumn('home_contents', 'hero_image')) {
                $table->dropColumn('hero_image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('home_contents', function (Blueprint $table) {
            // Revert back to string column if rolled back
            $table->string('hero_image')->nullable();

            if (Schema::hasColumn('home_contents', 'hero_images')) {
                $table->dropColumn('hero_images');
            }
        });
    }
};
