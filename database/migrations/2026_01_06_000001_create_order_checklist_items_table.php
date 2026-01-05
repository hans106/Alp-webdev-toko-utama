<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_checklist_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_checklist_id')->constrained('order_checklists')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products');
            $table->integer('qty_required')->default(0);
            $table->integer('qty_checked')->default(0);
            $table->string('status')->default('pending'); // pending | checked
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_checklist_items');
    }
};