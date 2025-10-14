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
        Schema::create('publishers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('city')->nullable();
            $table->string('country')->default('Perú');
            $table->string('website')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insertar editoriales desde libros existentes
        DB::statement("
            INSERT INTO publishers (name, city, country, created_at, updated_at)
            SELECT DISTINCT
                publisher,
                publisher_city,
                'Perú',
                NOW(),
                NOW()
            FROM books
            WHERE publisher IS NOT NULL AND publisher != ''
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publishers');
    }
};
