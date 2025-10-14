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
            // Actualizar language_code a valores válidos si es necesario
            DB::statement("UPDATE books SET language_code = 'es' WHERE language_code IS NULL OR language_code = ''");

            // Hacer language_code NOT NULL y agregar foreign key
            $table->string('language_code', 5)->default('es')->nullable(false)->change();

            // Agregar la foreign key constraint
            $table->foreign('language_code')
                ->references('code')
                ->on('languages')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['language_code']);

            // Revertir a nullable
            $table->string('language_code', 5)->nullable()->change();
        });
    }
};
