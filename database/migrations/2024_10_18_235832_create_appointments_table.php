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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('contact');
            $table->text('message');
            $table->enum('type', [
                \App\Enums\AppointmentType::VISIT->value,
                \App\Enums\AppointmentType::MEETING->value,
                \App\Enums\AppointmentType::ASKING_FOR_HELP->value,
            ]);       $table->dateTime('date');
            $table->float('duration');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
