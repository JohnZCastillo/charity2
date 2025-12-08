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
        Schema::table('donation_drive_data', function (Blueprint $table) {
            $table->enum('type',[
                \App\Enums\MoneyType::GCASH->value,
                \App\Enums\MoneyType::CASH->value,
            ]);
            $table->string('email')->nullable()->change();
            $table->string('receipt')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donation_drive_data', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->string('email')->nullable(false)->change();
            $table->string('receipt')->nullable(false)->change();
        });
    }
};
