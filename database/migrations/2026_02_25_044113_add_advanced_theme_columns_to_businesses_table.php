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
        Schema::table('businesses', function (Blueprint $table) {
            $table->foreignId('page_bg_color_id')->nullable()->constrained('themes')->nullOnDelete();
            $table->foreignId('card_bg_color_id')->nullable()->constrained('themes')->nullOnDelete();
            $table->foreignId('text_color_id')->nullable()->constrained('themes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropForeign(['page_bg_color_id']);
            $table->dropForeign(['card_bg_color_id']);
            $table->dropForeign(['text_color_id']);
            $table->dropColumn(['page_bg_color_id', 'card_bg_color_id', 'text_color_id']);
        });
    }
};
