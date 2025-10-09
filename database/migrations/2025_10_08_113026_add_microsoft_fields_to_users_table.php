<?php
// database/migrations/2024_01_20_000000_add_microsoft_fields_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('microsoft_id')->nullable()->unique();
            $table->string('institutional_email')->nullable()->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
            $table->text('azure_token')->nullable();
            $table->text('azure_refresh_token')->nullable();
            $table->timestamp('azure_token_expires_at')->nullable();

            // Cambiar role para incluir moderator
            $table->string('role')->default('user')->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'microsoft_id',
                'institutional_email',
                'is_active',
                'last_login_at',
                'azure_token',
                'azure_refresh_token',
                'azure_token_expires_at'
            ]);
        });
    }
};
