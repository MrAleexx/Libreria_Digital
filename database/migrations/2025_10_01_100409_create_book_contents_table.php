<?php

// database/migrations/2025_10_01_100409_create_book_contents_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->string('chapter_title', 200);
            $table->integer('chapter_number')->nullable();
            $table->integer('page_start')->nullable();
            $table->integer('page_end')->nullable();
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->tinyInteger('level')->default(0);
            $table->timestamps();

            $table->index(['book_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_contents');
    }
};
