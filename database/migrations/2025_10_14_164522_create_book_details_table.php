<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->unique()->constrained()->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('edition')->nullable()->default('1ra');
            $table->string('file_format')->nullable()->default('PDF');
            $table->string('file_size')->nullable();
            $table->string('reading_age')->nullable();
            $table->string('deposito_legal')->nullable();
            $table->text('restrictions')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Migrar datos existentes a book_details
        DB::statement("
            INSERT INTO book_details (
                book_id, description, edition, file_format, file_size,
                reading_age, deposito_legal, created_at, updated_at
            )
            SELECT
                id, description, edition, file_format, file_size,
                reading_age, deposito_legal, created_at, updated_at
            FROM books
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_details');
    }
};
