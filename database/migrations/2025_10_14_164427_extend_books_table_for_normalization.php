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
        Schema::table('books', function (Blueprint $table) {
            // Agregar nuevas columnas para normalización
            $table->foreignId('publisher_id')->nullable()->after('publisher');
            $table->string('language_code', 5)->default('es')->after('language');
            $table->year('publication_year')->nullable()->after('publication');
            $table->enum('book_type', ['digital', 'physical', 'both'])->default('digital')->after('downloadable');
            $table->enum('copyright_status', ['copyrighted', 'public_domain', 'creative_commons'])->default('copyrighted')->after('access_level');
            $table->string('license_type')->nullable()->after('copyright_status');

            // Agregar claves foráneas
            $table->foreign('publisher_id')->references('id')->on('publishers')->onDelete('set null');
            $table->foreign('language_code')->references('code')->on('languages')->onDelete('restrict');
        });

        // Actualizar publisher_id con datos existentes
        DB::statement("
            UPDATE books b
            JOIN publishers p ON b.publisher = p.name
            SET b.publisher_id = p.id
            WHERE b.publisher IS NOT NULL
        ");

        // Actualizar language_code
        DB::statement("
            UPDATE books
            SET language_code = LOWER(language),
                publication_year = YEAR(publication)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['publisher_id']);
            $table->dropForeign(['language_code']);

            $table->dropColumn([
                'publisher_id',
                'language_code',
                'publication_year',
                'book_type',
                'copyright_status',
                'license_type'
            ]);
        });
    }
};
