<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['name' => 'PT. Sumber Dagang', 'phone' => '081234567890', 'address' => 'Jl. Merdeka No.10, Jakarta'],
            ['name' => 'CV. Grosir Makmur', 'phone' => '081987654321', 'address' => 'Jl. Sudirman No.5, Bandung'],
            ['name' => 'UD. Distributor Sejahtera', 'phone' => '082112233445', 'address' => 'Jl. Panglima Polim No.3, Surabaya'],
        ];

        foreach ($suppliers as $s) {
            Supplier::firstOrCreate(['name' => $s['name']], [
                'phone' => $s['phone'],
                'address' => $s['address'],
            ]);
        }
    }
}
