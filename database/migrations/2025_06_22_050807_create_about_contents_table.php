<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('about_contents', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();                // Section title
            $table->text('content')->nullable();                // Main content (text or description)
            $table->json('items')->nullable();                  // For list-type sections (e.g. bullet items)
            $table->string('image')->nullable();                // Optional image
            $table->string('type')->default('text');            // 'text', 'list', 'image', etc.
            $table->string('group')->default('general');        // 'vision_mission', 'programs', etc.
            $table->integer('order')->default(0);               // Sort order
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_contents');
    }
};
