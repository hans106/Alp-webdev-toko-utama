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
        Schema::create('restock_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restock_id')->constrained('restocks')->onDelete('cascade');
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('status')->default('pending'); // pending, verified, rejected
            $table->text('notes')->nullable(); // Catatan verifikasi (jika ada masalah)
            $table->decimal('expected_total', 12, 2)->nullable(); // Total yang diharapkan (qty × harga)
            $table->decimal('actual_total', 12, 2)->nullable(); // Total dari nota asli
            $table->boolean('matches')->nullable(); // Apakah expected_total === actual_total
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            // Index untuk query cepat
            $table->index('restock_id');
            $table->index('status');
            $table->index('verified_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restock_verifications');
    }
};
