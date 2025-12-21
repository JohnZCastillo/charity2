<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('type', [
                \App\Enums\AppointmentType::VISIT->value,
                \App\Enums\AppointmentType::MEETING->value,
                \App\Enums\AppointmentType::ASKING_FOR_HELP->value,
                \App\Enums\AppointmentType::DONATION->value,
                \App\Enums\AppointmentType::OTHERS->value,
            ])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('type', [
                \App\Enums\AppointmentType::VISIT->value,
                \App\Enums\AppointmentType::MEETING->value,
                \App\Enums\AppointmentType::ASKING_FOR_HELP->value,
            ])->change();
        });
    }
};
