<?php

use App\Models\User;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Restock;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create an admin user with proper role
    $this->user = User::factory()->create(['role' => 'master']);

    // Minimal supplier & product
    $this->supplier = Supplier::create(['name' => 'Test Supplier', 'phone' => '', 'address' => '']);
    $this->product = Product::create(['name' => 'Test Product', 'slug' => 'test-product', 'stock' => 10, 'buy_price' => 1000]);

    $this->restock = Restock::create([
        'supplier_id' => $this->supplier->id,
        'product_id' => $this->product->id,
        'date' => now()->format('Y-m-d'),
        'qty' => 5,
        'buy_price' => 1000,
    ]);
});

it('does not allow marking sudah_fix without checked_qty or notes', function () {
    $response = $this->actingAs($this->user)->post(route('admin.restocks.checklist.update', $this->restock), [
        'checklist_status' => 'sudah_fix',
        // missing checked_qty and checklist_notes
    ]);

    $response->assertSessionHasErrors('checklist_status');

    $this->assertDatabaseHas('restocks', [
        'id' => $this->restock->id,
        'checklist_status' => null,
    ]);
});

it('allows marking sudah_fix when checked_qty and notes provided, and index shows Selesai', function () {
    $response = $this->actingAs($this->user)->post(route('admin.restocks.checklist.update', $this->restock), [
        'checklist_status' => 'sudah_fix',
        'checked_qty' => 5,
        'checklist_notes' => 'OK',
    ]);

    $response->assertSessionHas('success');

    $this->assertDatabaseHas('restocks', [
        'id' => $this->restock->id,
        'checklist_status' => 'sudah_fix',
        'checked_qty' => 5,
        'checklist_notes' => 'OK',
    ]);

    $index = $this->actingAs($this->user)->get(route('admin.restocks.index'));
    $index->assertSee('Selesai');
    // The row should not have Edit or Batal buttons for the completed restock
    $index->assertDontSee('Batal');
});
