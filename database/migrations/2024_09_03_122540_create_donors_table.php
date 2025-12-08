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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->index()->unique();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile');
            $table->enum('status', [
                \App\Enums\UserStatus::ENABLED->value,
                \App\Enums\UserStatus::DISABLED->value,
            ]);
            $table->enum('type', [
                \App\Enums\UserType::DONOR->value,
                \App\Enums\UserType::RECIPIENT->value,
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
