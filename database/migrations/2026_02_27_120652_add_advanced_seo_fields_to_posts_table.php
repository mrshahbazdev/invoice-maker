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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('focus_keyword')->nullable()->after('meta_description');
            $table->string('canonical_url')->nullable()->after('focus_keyword');

            // Semantic SEO / Schema
            $table->string('schema_type')->default('Article')->after('canonical_url');
            $table->json('schema_markup')->nullable()->after('schema_type');

            // Local SEO
            $table->string('local_seo_city')->nullable()->after('schema_markup');
            $table->string('local_seo_region')->nullable()->after('local_seo_city');

            // Internal Linking
            $table->json('related_post_ids')->nullable()->after('local_seo_region');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn([
                'focus_keyword',
                'canonical_url',
                'schema_type',
                'schema_markup',
                'local_seo_city',
                'local_seo_region',
                'related_post_ids',
            ]);
        });
    }
};
