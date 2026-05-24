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
        Schema::table('invoices', function (Blueprint $table) {
            $table->boolean('is_recurring')->default(false)->after('amount_due');
            $table->string('recurring_frequency')->nullable()->after('is_recurring'); // weekly, monthly, quarterly, yearly
            $table->date('next_run_date')->nullable()->after('recurring_frequency');
            $table->date('last_run_date')->nullable()->after('next_run_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['is_recurring', 'recurring_frequency', 'next_run_date', 'last_run_date']);
        });
    }
};
