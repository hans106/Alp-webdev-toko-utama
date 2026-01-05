<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('order_checklists', function (Blueprint $table) {
            $table->string('status')->default('belum_selesai')->after('notes'); // 'belum_selesai' | 'sudah_fix'
        });
    }

    public function down()
    {
        Schema::table('order_checklists', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};