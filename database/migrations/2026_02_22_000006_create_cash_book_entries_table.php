<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cash_book_entries', function (Blueprint $row) {
            $row->id();
            $row->foreignId('business_id')->constrained()->onDelete('cascade');
            $row->string('booking_number')->unique();
            $row->date('date');
            $row->decimal('amount', 15, 2);
            $row->enum('type', ['income', 'expense']);
            $row->enum('source', ['cash', 'bank']);
            $row->string('description')->nullable();
            $row->foreignId('category_id')->nullable()->constrained('accounting_categories')->onDelete('set null');
            $row->foreignId('invoice_id')->nullable()->constrained()->onDelete('set null');
            $row->foreignId('expense_id')->nullable()->constrained()->onDelete('set null');
            $row->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_book_entries');
    }
};
