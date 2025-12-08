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
        Schema::create('item_stock_ins', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity')->default(0);
            $table->integer('active_quantity')->default(0);
            $table->date('expiration')->nullable();
            $table->foreignId('item_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_stock_ins');
    }
};
