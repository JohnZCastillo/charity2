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
        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('item_category_id')->nullable()->constrained();
            $table->foreignId('item_size_id')->nullable()->constrained();
            $table->foreignId('item_gender_id')->nullable()->constrained();
            $table->foreignId('account_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign('items_item_category_id_foreign');
            $table->dropForeign('items_item_gender_id_foreign');
            $table->dropForeign('items_item_size_id_foreign');
            $table->dropForeign('items_account_id_foreign');

            $table->dropColumn('item_category_id');
            $table->dropColumn('item_size_id');
            $table->dropColumn('item_gender_id');
            $table->dropColumn('account_id');
        });
    }
};
