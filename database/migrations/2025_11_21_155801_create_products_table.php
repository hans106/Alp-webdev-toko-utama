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
            
            // Relasi ke tabel categories & brands
            // Kalau kategori dihapus, produknya ikut terhapus (cascade) biar database bersih
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            
            $table->string('name'); // Nama Barang: Indomie Goreng
            $table->string('slug')->unique(); // URL: indomie-goreng
            $table->integer('price'); // Harga Jual: 3500
            $table->integer('stock')->default(0); // Stok awal: 0
            $table->text('description')->nullable(); // Penjelasan barang
            $table->string('image')->nullable(); // Foto barang utama
            
            // Status barang (aktif/tidak)
            $table->boolean('is_active')->default(true); 
            
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
