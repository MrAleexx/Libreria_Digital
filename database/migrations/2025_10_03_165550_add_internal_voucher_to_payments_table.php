<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('internal_voucher')->nullable()->after('voucher_image');
            $table->string('internal_voucher_uploaded_by')->nullable()->after('internal_voucher');
            $table->timestamp('internal_voucher_uploaded_at')->nullable()->after('internal_voucher_uploaded_by');
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['internal_voucher', 'internal_voucher_uploaded_by', 'internal_voucher_uploaded_at']);
        });
    }
};
