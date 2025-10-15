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
            // Eliminar el campo inconsistente is_featured_new
            $table->dropColumn('is_featured_new');

            // Asegurar que featured tenga valor por defecto correcto
            $table->boolean('featured')->default(false)->change();

            // Agregar índice para mejor performance en búsquedas
            $table->index(['featured', 'is_active'], 'books_featured_active_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropIndex('books_featured_active_index');

            // Recuperar el campo eliminado si es necesario hacer rollback
            $table->boolean('is_featured_new')->default(false)->after('featured');
        });
    }
};
