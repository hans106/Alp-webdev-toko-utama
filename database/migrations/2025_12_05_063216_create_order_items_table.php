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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            // Nempel ke Nota mana?
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            // Barang apa?
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->integer('qty');
            $table->decimal('price', 15, 2); // Harga saat beli (penting!)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
