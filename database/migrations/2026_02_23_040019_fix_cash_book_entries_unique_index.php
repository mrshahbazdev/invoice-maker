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
        Schema::table('cash_book_entries', function (Blueprint $table) {
            $table->dropUnique('cash_book_entries_booking_number_unique');
            $table->unique(['business_id', 'booking_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cash_book_entries', function (Blueprint $table) {
            $table->dropUnique(['business_id', 'booking_number']);
            $table->unique('booking_number');
        });
    }
};
