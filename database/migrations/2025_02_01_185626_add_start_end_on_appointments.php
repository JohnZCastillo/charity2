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
        Schema::table('appointments', function (Blueprint $table) {
            $table->date('date');
            $table->time('start');
            $table->time('end');

            $table->dropForeign('appointments_appointment_slot_id_foreign');
            $table->dropColumn('appointment_slot_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->dropColumn('start');
            $table->dropColumn('end');
            $table->foreignId('appointment_slot_id')->constrained();
        });
    }
};
