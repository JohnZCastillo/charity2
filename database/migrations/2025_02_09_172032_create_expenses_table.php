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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->string('purpose');
            $table->string('receipt')->nullable();
            $table->enum('type', [
                \App\Enums\ExpenseType::DONATE->value,
                \App\Enums\ExpenseType::EXPENSE->value,
            ]);
            $table->foreignId('account_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
