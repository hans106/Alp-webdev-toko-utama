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
        Schema::create('products', function (Blueprint $table) {
           $table->id();
        // Relasi
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->foreignId('brand_id')->constrained()->onDelete('cascade');
        
        $table->string('name');
        $table->string('slug')->unique();
        $table->integer('price'); // Pakai integer biar gampang
        $table->integer('stock')->default(0);
        $table->text('description')->nullable();
        
        // FOTO UTAMA
        $table->string('image_main')->nullable(); // Pengganti image_path
        
        $table->boolean('is_active')->default(true); // Buat on/off produk
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
