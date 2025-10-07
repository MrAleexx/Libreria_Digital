<?php

// database/migrations/2025_10_01_100401_create_book_contributors_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_contributors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->string('contributor_type')->default('author');
            $table->string('full_name', 200);
            $table->string('email', 100)->nullable();
            $table->integer('sequence_number')->default(1);
            $table->text('biographical_note')->nullable();
            $table->timestamps();

            $table->index(['book_id', 'sequence_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_contributors');
    }
};
