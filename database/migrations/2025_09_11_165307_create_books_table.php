<?php

// database/migrations/2025_09_11_165307_create_books_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('publisher', 255);
            $table->string('publisher_address', 500)->nullable();
            $table->string('publisher_email', 100)->nullable();
            $table->string('publisher_city', 100)->nullable();
            $table->string('isbn', 20)->unique();
            $table->string('isbn13', 20)->nullable();
            $table->string('deposito_legal', 50)->nullable();
            $table->string('language', 10);
            $table->integer('pages');
            $table->string('file_size', 50)->nullable();
            $table->string('file_format', 10)->default('PDF');
            $table->date('publication');
            $table->string('publication_url', 500)->nullable();
            $table->string('edition', 100)->default('1er');
            $table->decimal('price', 10, 2);
            $table->string('image', 255);
            $table->string('pdf_file', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('reading_age', 50)->nullable();
            $table->boolean('is_new')->default(false);
            $table->boolean('active')->default(true);
            $table->boolean('downloadable')->default(true);
            $table->boolean('pre_order')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
