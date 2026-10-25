<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->string('tax_country', 2)->nullable()->after('tax_number');
            $table->decimal('tax_rate', 5, 2)->nullable()->after('tax_country');
        });
    }

    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn(['tax_country', 'tax_rate']);
        });
    }
};
