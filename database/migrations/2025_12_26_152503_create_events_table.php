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
        Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('title');        // Judul Event (Contoh: Gala Dinner)
        $table->string('location');     // Lokasi (Contoh: Omah Sinten Solo)
        $table->date('event_date');     // Tanggal (Contoh: 2011-04-15)
        $table->string('image');        // Nama File Foto
        $table->text('description')->nullable(); // Penjelasan (Boleh kosong)
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
