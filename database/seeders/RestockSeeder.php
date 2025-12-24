<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restock;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class RestockSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = Supplier::all();
        if ($suppliers->isEmpty()) {
            return; // ensure suppliers exist
        }

        // Select some products to restock
        $products = Product::inRandomOrder()->take(8)->get();

        foreach ($products as $product) {
            $supplier = $suppliers->random();
            $qty = rand(10, 50);
            $buyPrice = max(1000, round($product->price * 0.65, 2));
            $date = now()->subDays(rand(0, 30))->toDateString();

            // Create restock record
            Restock::firstOrCreate([
                'supplier_id' => $supplier->id,
                'product_id' => $product->id,
                'qty' => $qty,
                'buy_price' => $buyPrice,
                'date' => $date,
            ]);

            // Safely increment product stock inside transaction
            DB::transaction(function () use ($product, $qty) {
                $product->increment('stock', $qty);
            });
        }
    }
}
