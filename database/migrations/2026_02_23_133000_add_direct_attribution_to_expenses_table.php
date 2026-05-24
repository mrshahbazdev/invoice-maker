<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('client_id')->nullable()->constrained()->onDelete('set null')->after('business_id');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null')->after('client_id');
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });
    }
};
