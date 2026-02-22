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
        Schema::create('invoice_comments', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('invoice_id')->constrained()->onDelete('cascade');
            $blueprint->foreignId('user_id')->constrained()->onDelete('cascade');
            $blueprint->text('comment');
            $blueprint->boolean('is_internal')->default(false);
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_comments');
    }
};
