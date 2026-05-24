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
        Schema::table('accounting_categories', function (Blueprint $table) {
            $table->string('booking_account')->nullable()->after('type');
        });

        Schema::table('businesses', function (Blueprint $table) {
            $table->string('bank_booking_account')->nullable()->after('bank_details');
            $table->string('cash_booking_account')->nullable()->after('bank_booking_account');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounting_categories', function (Blueprint $table) {
            $table->dropColumn('booking_account');
        });

        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn(['bank_booking_account', 'cash_booking_account']);
        });
    }
};
