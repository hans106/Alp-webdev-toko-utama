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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        // Ganti user_id jadi constrained biar aman kalau user dihapus
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('invoice_code')->unique(); 
        $table->decimal('total_price', 15, 2);
        // --- STATUS DIPECAH DUA BIAR JELAS ---
        // 1. Status Bayar (Pending, Lunas, Batal)
        $table->enum('payment_status', ['1', '2', '3', '4'])->default('1')->comment('1=Menunggu, 2=Lunas, 3=Kadaluarsa, 4=Batal');
        // 2. Status Barang (Dikemas, Dikirim, Selesai)
        $table->enum('delivery_status', ['pending', 'processing', 'shipped', 'completed'])->default('pending');
        $table->string('snap_token')->nullable(); // <--- WAJIB ADA BUAT MIDTRANS        
        $table->text('address')->nullable(); 
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
