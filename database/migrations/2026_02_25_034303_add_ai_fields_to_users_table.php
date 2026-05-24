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
        Schema::table('users', function (Blueprint $table) {
            $table->string('openai_api_key')->nullable()->after('language');
            $table->string('anthropic_api_key')->nullable()->after('openai_api_key');
            $table->string('default_ai_provider')->default('openai')->after('anthropic_api_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['openai_api_key', 'anthropic_api_key', 'default_ai_provider']);
        });
    }
};
