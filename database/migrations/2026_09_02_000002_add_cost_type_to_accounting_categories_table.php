<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('accounting_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('accounting_categories', 'cost_type')) {
                $table->enum('cost_type', ['F', 'V'])->default('F')->after('type'); // F = Fixed, V = Variable
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounting_categories', function (Blueprint $table) {
            if (Schema::hasColumn('accounting_categories', 'cost_type')) {
                $table->dropColumn('cost_type');
            }
        });
    }
};
