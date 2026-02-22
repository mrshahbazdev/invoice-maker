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
            $table->string('stripe_account_id')->nullable()->after('plan');
            $table->boolean('stripe_onboarding_complete')->default(false)->after('stripe_account_id');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->string('currency', 3)->nullable()->after('country')->comment('Overrides business default');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->string('currency', 3)->nullable()->after('status');
            $table->string('stripe_payment_intent_id')->nullable()->after('currency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn(['stripe_account_id', 'stripe_onboarding_complete']);
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('currency');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['currency', 'stripe_payment_intent_id']);
        });
    }
};
