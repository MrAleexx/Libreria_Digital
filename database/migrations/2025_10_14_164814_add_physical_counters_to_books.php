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
            $table->integer('total_physical_copies')->default(0)->after('total_downloads');
            $table->integer('available_physical_copies')->default(0)->after('total_physical_copies');
            $table->integer('total_loans')->default(0)->after('available_physical_copies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['total_physical_copies', 'available_physical_copies', 'total_loans']);
        });
    }
};
