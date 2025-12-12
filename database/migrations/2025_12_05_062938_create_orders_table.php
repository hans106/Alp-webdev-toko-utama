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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->decimal('total_price', 15, 2);

            // Status Pesanan
            $table->enum('status', ['pending', 'paid', 'sent', 'done', 'cancelled'])->default('pending');

            $table->string('invoice_code')->unique();
            $table->text('address'); // Alamat + No HP

            // --- TAMBAHAN BARU ---
            $table->string('payment_method')->nullable(); // BCA VA, dll
            $table->string('payment_receipt')->nullable(); // Bukti bayar / Link PDF Midtrans
            $table->timestamp('paid_at')->nullable(); // Kapan lunasnya
            $table->string('snap_token')->nullable(); // WAJIB BUAT MIDTRANS (Saran saya tetap adakan ini)
            // ---------------------

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
