<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('restocks', function (Blueprint $table) {
            $table->integer('checked_qty')->nullable()->after('qty');
            $table->string('checklist_status')->nullable()->after('checked_qty'); // e.g. 'belum_selesai', 'sudah_fix'
            $table->text('checklist_notes')->nullable()->after('checklist_status');
        });
    }

    public function down()
    {
        Schema::table('restocks', function (Blueprint $table) {
            $table->dropColumn(['checked_qty', 'checklist_status', 'checklist_notes']);
        });
    }
};
