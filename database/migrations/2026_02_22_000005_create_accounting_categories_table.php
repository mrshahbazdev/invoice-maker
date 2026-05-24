<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('accounting_categories', function (Blueprint $row) {
            $row->id();
            $row->foreignId('business_id')->constrained()->onDelete('cascade');
            $row->string('name');
            $row->enum('type', ['income', 'expense'])->default('expense');
            $row->text('posting_rule')->nullable();
            $row->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounting_categories');
    }
};
