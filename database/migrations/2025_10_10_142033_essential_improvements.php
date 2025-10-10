<?php
// database/migrations/2025_10_10_142033_essential_improvements.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. MEJORAR TABLA USERS - Campos críticos únicamente
        Schema::table('users', function (Blueprint $table) {
            // Contraseñas temporales
            $table->boolean('is_temp_password')->default(true)->after('password');
            $table->timestamp('temp_password_expires_at')->nullable()->after('is_temp_password');

            // Control de descargas diarias
            $table->integer('downloads_today')->default(0)->after('role');
            $table->date('last_download_reset')->nullable()->after('downloads_today');

            // Gestión por administradores
            $table->foreignId('created_by')->nullable()->after('last_download_reset')
                ->constrained('users')->onDelete('set null');
        });

        // 2. TABLA DE DESCARGAS - Para tracking y límites
        Schema::create('user_downloads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->dateTime('downloaded_at');
            $table->string('ip_address', 45);
            $table->timestamps();

            // Índices para optimizar consultas de límites
            $table->index(['user_id', 'downloaded_at']);
            $table->index(['downloaded_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_downloads');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn([
                'is_temp_password',
                'temp_password_expires_at',
                'downloads_today',
                'last_download_reset',
                'created_by'
            ]);
        });
    }
};
