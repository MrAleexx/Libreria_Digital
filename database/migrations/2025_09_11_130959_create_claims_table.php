<?php

// database/migrations/2025_09_11_130959_create_claims_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('dni');
            $table->string('email');
            $table->enum('tipo_reclamo', ['problema_descarga', 'cobro_indebido', 'acceso_cuenta', 'otro']);
            $table->string('subject');
            $table->string('description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
