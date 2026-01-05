<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // No-op: drop migration disabled to allow restoring the OrderChecklist feature. Kept for historical purposes.
    }

    public function down()
    {
        // Recreate tables if missing (used to restore after accidental drop)
        if (! Schema::hasTable('order_checklists')) {
            Schema::create('order_checklists', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained()->onDelete('cascade');
                $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
                $table->string('recipient_name');
                $table->integer('items_count')->default(0);
                $table->text('notes')->nullable();
                $table->string('status')->default('belum_selesai');
                $table->timestamp('sent_at')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('order_checklist_items')) {
            Schema::create('order_checklist_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_checklist_id')->constrained('order_checklists')->cascadeOnDelete();
                $table->foreignId('product_id')->constrained('products');
                $table->integer('qty_required')->default(0);
                $table->integer('qty_checked')->default(0);
                $table->string('status')->default('pending');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }
};