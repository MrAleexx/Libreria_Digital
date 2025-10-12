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
            $table->dropColumn(['price', 'is_free', 'pre_order']);
        });

        // Agregar columnas de biblioteca
        Schema::table('books', function (Blueprint $table) {
            $table->integer('total_downloads')->default(0)->after('downloadable');
            $table->integer('total_views')->default(0)->after('total_downloads');
            $table->boolean('featured')->default(false)->after('total_views');
            $table->enum('access_level', ['free', 'premium', 'institutional'])->default('free')->after('featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restaurar columnas de e-commerce
        Schema::table('books', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('is_free')->default(false);
            $table->boolean('pre_order')->default(false);
        });

        // Eliminar columnas de biblioteca
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['total_downloads', 'total_views', 'featured', 'access_level']);
        });
    }
};
