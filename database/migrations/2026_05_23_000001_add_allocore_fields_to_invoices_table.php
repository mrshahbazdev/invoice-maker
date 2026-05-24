<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('allocore_order_id')->nullable()->index()->after('id');
            $table->string('allocore_subscription_id')->nullable()->index()->after('allocore_order_id');
            $table->string('source')->default('manual')->after('payment_terms');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['allocore_order_id', 'allocore_subscription_id', 'source']);
        });
    }
};
