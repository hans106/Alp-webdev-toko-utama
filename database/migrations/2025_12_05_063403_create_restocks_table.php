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
        Schema::create('restocks', function (Blueprint $table) {
            $table->id();
            // Beli dari siapa? (Supplier)
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            // Beli barang apa? (Product)
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->integer('qty'); // Jumlah masuk
            $table->decimal('buy_price', 15, 2); // Harga modal
            $table->date('date'); // Tanggal beli

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restocks');
    }
};
