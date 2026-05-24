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
        Schema::table('templates', function (Blueprint $table) {
            $table->string('header_style')->default('default')->after('font_family');
            $table->text('footer_message')->nullable()->after('header_style');
            $table->text('signature_path')->nullable()->after('footer_message');
            $table->text('payment_terms')->nullable()->after('signature_path');
            $table->boolean('show_tax')->default(true)->after('payment_terms');
            $table->boolean('show_discount')->default(true)->after('show_tax');
            $table->boolean('enable_qr')->default(false)->after('show_discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropColumn([
                'header_style',
                'footer_message',
                'signature_path',
                'payment_terms',
                'show_tax',
                'show_discount',
                'enable_qr',
            ]);
        });
    }
};
