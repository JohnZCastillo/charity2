<?php

use App\Enums\AppointmentSlotType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointment_slots', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('capacity');
            $table->enum('type', [
                AppointmentSlotType::AM->value,
                AppointmentSlotType::PM->value,
            ]);
            $table->unique(['date', 'type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_slots');
    }
};
