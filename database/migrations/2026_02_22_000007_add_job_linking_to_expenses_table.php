<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $row) {
            $row->foreignId('invoice_id')->nullable()->constrained()->onDelete('set null')->after('business_id');
            $row->foreignId('category_id')->nullable()->constrained('accounting_categories')->onDelete('set null')->after('invoice_id');
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $row) {
            $row->dropForeign(['invoice_id']);
            $row->dropColumn('invoice_id');
            $row->dropForeign(['category_id']);
            $row->dropColumn('category_id');
        });
    }
};
