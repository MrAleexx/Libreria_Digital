<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Eliminar columnas redundantes que ahora están en book_details
            $table->dropColumn([
                'publisher',
                'publisher_address',
                'publisher_email',
                'publisher_city',
                'isbn13',
                'deposito_legal',
                'language',
                'file_size',
                'file_format',
                'publication',
                'publication_url',
                'edition',
                'description',
                'reading_age'
            ]);

            // Renombrar columnas para consistencia
            $table->renameColumn('image', 'cover_image');
            $table->renameColumn('active', 'is_active');
            $table->renameColumn('is_new', 'is_featured_new'); // Para distinguir de "featured"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Restaurar nombres
            $table->renameColumn('cover_image', 'image');
            $table->renameColumn('is_active', 'active');
            $table->renameColumn('is_featured_new', 'is_new');

            // Restaurar columnas eliminadas (simplificado)
            $table->string('publisher')->nullable();
            $table->string('publisher_address', 500)->nullable();
            $table->string('publisher_email', 100)->nullable();
            $table->string('publisher_city', 100)->nullable();
            $table->string('isbn13', 20)->nullable();
            $table->string('deposito_legal', 50)->nullable();
            $table->string('language', 10)->default('es');
            $table->string('file_size', 50)->nullable();
            $table->string('file_format', 10)->default('PDF');
            $table->date('publication')->nullable();
            $table->string('publication_url', 500)->nullable();
            $table->string('edition', 100)->default('1er');
            $table->text('description')->nullable();
            $table->string('reading_age', 50)->nullable();
        });
    }
};
