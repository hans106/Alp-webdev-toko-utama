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
            
            // Relasi ke User
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Total Harga
            $table->decimal('total_price', 15, 2);

            // --- PERBAIKAN UTAMA DISINI ---
            // Status Pesanan (Sudah Lengkap untuk Midtrans & Gudang)
            $table->enum('status', [
                'unpaid',       // Belum bayar (Default awal)
                'pending',      // Menunggu pembayaran (Midtrans pending)
                'paid',         // Sudah dibayar (Manual)
                'settlement',   // LUNAS (Istilah resmi Midtrans)
                'processing',   // DIPROSES GUDANG (Supaya tidak error lagi saat dikirim ke checklist)
                'sent',         // Sedang dikirim kurir
                'done',         // Selesai / Diterima
                'cancelled',    // Dibatalkan
                'expire',       // Kadaluarsa (Midtrans)
                'deny'          // Ditolak (Midtrans)
            ])->default('unpaid');

            // Data Invoice & Alamat
            $table->string('invoice_code')->unique();
            $table->text('address'); // Alamat + No HP

            // --- DATA PEMBAYARAN ---
            $table->string('payment_method')->nullable(); // BCA VA, Gopay, dll
            $table->string('payment_receipt')->nullable(); // Bukti bayar / Link PDF Midtrans
            $table->timestamp('paid_at')->nullable(); // Waktu lunas
            $table->string('snap_token')->nullable(); // Token Pembayaran Midtrans

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