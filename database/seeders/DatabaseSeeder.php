<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
// ==========================================
        // 1. USER & ROLES (YANG FINAL)
        // ==========================================
        
        // 👑 SUPER ADMIN (BOS BESAR - Bisa Akses Semua)
        User::firstOrCreate([
            'email' => 'superadmin@tokoUtama.com',
        ], [
            'name' => 'Owner (Super Admin)', // Boleh ganti nama jadi 'Hansvere' kalau mau
            'password' => Hash::make('superadmin123'),
            'role' => 'superadmin',
        ]);

        // 📦 INVENTORY (Staff Gudang)
        User::firstOrCreate([
            'email' => 'inventory@tokoUtama.com',
        ], [
            'name' => 'Staff Gudang',
            'password' => Hash::make('inventory123'),
            'role' => 'inventory',
        ]);

        // 💰 CASHIER (Kasir)
        User::firstOrCreate([
            'email' => 'kasir@tokoUtama.com',
        ], [
            'name' => 'Staff Kasir',
            'password' => Hash::make('kasir123'),
            'role' => 'cashier',
        ]);

        // 👤 CUSTOMER (Pembeli)
        User::firstOrCreate([
            'email' => 'budi@gmail.com',
        ], [
            'name' => 'Budi Pembeli',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // ==========================================
        // 2. KATEGORI
        // ==========================================
        $catSembako = Category::firstOrCreate(['slug' => 'sembako'], ['name' => 'Sembako']);
        $catMinuman = Category::firstOrCreate(['slug' => 'minuman'], ['name' => 'Minuman']);
        $catJajanan = Category::firstOrCreate(['slug' => 'jajanan'], ['name' => 'Jajanan']);
        $catSabun   = Category::firstOrCreate(['slug' => 'sabun'], ['name' => 'Sabun & Cuci']);
        $catRokok   = Category::firstOrCreate(['slug' => 'rokok'], ['name' => 'Rokok']);

        // ==========================================
        // 3. BRAND (SESUAI DUNIA NYATA)
        // ==========================================
        
        // --- Perusahaan Besar (FMCG) ---
        Brand::firstOrCreate(['slug' => 'indofood'], ['name' => 'Indofood']);
        Brand::firstOrCreate(['slug' => 'unilever'], ['name' => 'Unilever']);
        Brand::firstOrCreate(['slug' => 'wings'], ['name' => 'Wings Group']);
        Brand::firstOrCreate(['slug' => 'mayora'], ['name' => 'Mayora']);
        Brand::firstOrCreate(['slug' => 'so-good'], ['name' => 'So Good Food']);
        Brand::firstOrCreate(['slug' => 'danone'], ['name' => 'Danone']);
        Brand::firstOrCreate(['slug' => 'coca-cola'], ['name' => 'Coca-Cola']);
        Brand::firstOrCreate(['slug' => 'kino'], ['name' => 'Kino']);
        Brand::firstOrCreate(['slug' => 'otsuka'], ['name' => 'Otsuka']);
        Brand::firstOrCreate(['slug' => 'nestle'], ['name' => 'Nestle']);
        Brand::firstOrCreate(['slug' => 'frisian-flag'], ['name' => 'Frisian Flag']);
        Brand::firstOrCreate(['slug' => 'ultrajaya'], ['name' => 'Ultrajaya']);
        Brand::firstOrCreate(['slug' => 'sosro'], ['name' => 'Sosro']);
        Brand::firstOrCreate(['slug' => 'tong-tji'], ['name' => 'Tong Tji']);
        Brand::firstOrCreate(['slug' => 'sido-muncul'], ['name' => 'Sido Muncul']);
        Brand::firstOrCreate(['slug' => 'kapal-api'], ['name' => 'Kapal Api Global']);
        Brand::firstOrCreate(['slug' => 'sari-incofood'], ['name' => 'Sari Incofood']);
        Brand::firstOrCreate(['slug' => 'bkp'], ['name' => 'Bina Karya Prima']);
        Brand::firstOrCreate(['slug' => 'marie-regal'], ['name' => 'Marie Regal']);
        Brand::firstOrCreate(['slug' => 'nissin'], ['name' => 'Nissin']);
        Brand::firstOrCreate(['slug' => 'sinar-mas'], ['name' => 'Sinar Mas']);
        Brand::firstOrCreate(['slug' => 'sugar-group'], ['name' => 'Sugar Group']);
        Brand::firstOrCreate(['slug' => 'umum'], ['name' => 'Umum']);

        // --- Pabrik Rokok ---
        Brand::firstOrCreate(['slug' => 'bentoel'], ['name' => 'Bentoel Group (BAT)']);
        Brand::firstOrCreate(['slug' => 'jti'], ['name' => 'JTI (Camel)']);
        Brand::firstOrCreate(['slug' => 'djarum'], ['name' => 'Djarum']);
        Brand::firstOrCreate(['slug' => 'gudang-garam'], ['name' => 'Gudang Garam']);
        Brand::firstOrCreate(['slug' => 'sampoerna'], ['name' => 'HM Sampoerna']);

        // ==========================================
        // 4. PRODUK (MAPPING AKURAT)
        // ==========================================

        // --- ROKOK ---
        $daftarRokok = [
            // Dunhill
            ['brand' => 'bentoel', 'name' => 'Dunhill Filter 16', 'price' => 32500, 'image' => '1._Dunhill_Filter16_Evoque_Rp_32.500.png'],
            ['brand' => 'bentoel', 'name' => 'Dunhill Blue 20', 'price' => 28500, 'image' => '2._Dunhill_Blue_20_Rp_28.500.png'],
            ['brand' => 'bentoel', 'name' => 'Dunhill Green 20', 'price' => 28500, 'image' => '3._Dunhill_Green_20_Rp_28.500.png'],
            ['brand' => 'bentoel', 'name' => 'Lucky Strike Purple 20', 'price' => 30000, 'image' => '4._Lucky_Strike_Purple_20_Rp_30.000.png'],
            ['brand' => 'bentoel', 'name' => 'Lucky Strike Cool Switch 20', 'price' => 30000, 'image' => '5._Lucky_Strike_Cool_Switch_20_Rp_30.000.png'],
            ['brand' => 'bentoel', 'name' => 'Lucky Strike Red 20', 'price' => 29000, 'image' => '6._Lucky_Strike_Red_20_Rp_29.000.png'],
            ['brand' => 'bentoel', 'name' => 'Dunhill Black 12', 'price' => 22000, 'image' => '7._Dunhill_Black_12_Rp_.22.000.png'],
            ['brand' => 'bentoel', 'name' => 'Dunhill Black 16', 'price' => 30000, 'image' => '8._Dunhill_Black_16_Rp_30.000.png'],
            ['brand' => 'bentoel', 'name' => 'Dunhill White 16', 'price' => 30000, 'image' => '9._Dunhill_White_16_Rp_30.000.png'],
            ['brand' => 'bentoel', 'name' => 'Dunhill White 20', 'price' => 38000, 'image' => '10._Dunhill_White_20_Rp_38.000.png'],
            ['brand' => 'bentoel', 'name' => 'Country Light 20', 'price' => 27000, 'image' => '11._Country_Light__20_Rp_27.000.png'],
            ['brand' => 'bentoel', 'name' => 'Country Red 20', 'price' => 27000, 'image' => '12._Country_Red_20_Rp_27.000.png'],
            ['brand' => 'bentoel', 'name' => 'Bentoel Sejati 12', 'price' => 9500, 'image' => '13._Bentoel_Sejati_12_Rp_9.500.png'],
            
            // JTI (Camel)
            ['brand' => 'jti', 'name' => 'Camel Purple 16', 'price' => 19500, 'image' => '14._Camel_Purple_16_Rp_19.500.png'],
            ['brand' => 'jti', 'name' => 'Camel Purple 12', 'price' => 25500, 'image' => '15._Camel_Purple_12_Rp_25.500.png'],
            ['brand' => 'jti', 'name' => 'Camel Connect 20', 'price' => 30000, 'image' => '16._Camel_Connect_20_Rp_30.000.png'],
            ['brand' => 'jti', 'name' => 'Camel Blue 16', 'price' => 23000, 'image' => '17._Camel_Blue16_Rp_23.000.png'],
            ['brand' => 'jti', 'name' => 'Camel Ice Red 16', 'price' => 25500, 'image' => '18._Camel_Ice_Red_16_Rp_25.500.png'],
            ['brand' => 'jti', 'name' => 'Camel Kretek 12', 'price' => 25500, 'image' => '19._Camel_Kretek_12_Rp_14.000.png'],
            
            // DJARUM (LA, Tenor, Viper, 76)
            ['brand' => 'djarum', 'name' => 'LA Ice Purple 16', 'price' => 33500, 'image' => '20._LA_IcePurple_16_Rp_33.500.png'],
            ['brand' => 'djarum', 'name' => 'Tenor Hijau 12', 'price' => 9500, 'image' => '21._Tenor_Hijau_12_Rp_9.500.png'],
            ['brand' => 'djarum', 'name' => 'Tenor Teh Manis 12', 'price' => 9500, 'image' => '22._Tenor_teh_manis_12_Rp_9.500.png'],
            ['brand' => 'djarum', 'name' => 'Viper Red 16', 'price' => 21000, 'image' => '23._Viper_Red_16_Rp_21.000.png'],
            ['brand' => 'djarum', 'name' => 'Djarum 76', 'price' => 16000, 'image' => '24._Djarum76_12_Rp_16.000.png'],
            ['brand' => 'djarum', 'name' => 'Djarum 76 Apel 12', 'price' => 14500, 'image' => '25._76_Apel_12_Rp_14.500.png'],
            ['brand' => 'djarum', 'name' => 'Djarum 76 Nanas 12', 'price' => 14500, 'image' => '26._Djarum76_Nanas_12_Rp_14.500.png'],
            ['brand' => 'djarum', 'name' => 'Djarum 76 Filter Gold', 'price' => 23000, 'image' => '27._Djarum_76_Filter_Gold_12_Rp_23.000.png'],
            ['brand' => 'djarum', 'name' => 'LA Ice 16', 'price' => 35000, 'image' => '28._LA_Ice_16_Rp_35.500.png'],
            ['brand' => 'djarum', 'name' => 'LA Mentol 16', 'price' => 35000, 'image' => '29._LA_Mentol_16__Rp_35.500.png'],
            ['brand' => 'djarum', 'name' => 'LA Light 16', 'price' => 33500, 'image' => '30._LA_Light_16_Rp_33.500.png'],
            ['brand' => 'djarum', 'name' => 'LA Bold 12', 'price' => 22500, 'image' => '31._LA_Bold_12_Rp_22.500.png'],
            ['brand' => 'djarum', 'name' => 'LA Bold 20', 'price' => 38000, 'image' => '32._LA_Bold_20_Rp_38.000.png'],
            ['brand' => 'djarum', 'name' => 'LA Bold 16', 'price' => 30000, 'image' => '33._LA_Bold_16_Rp30.000.png'], 
        ];

        foreach ($daftarRokok as $rokok) {
            Product::firstOrCreate([
                'slug' => Str::slug($rokok['name']),
            ], [
                'name' => $rokok['name'],
                'category_id' => $catRokok->id,
                'brand_id' => Brand::where('slug', $rokok['brand'])->first()->id,
                'price' => $rokok['price'],
                'stock' => 50,
                'description' => 'Peringatan: Rokok mengandung zat adiktif yang berbahaya bagi kesehatan.',
                'image_main' => 'products/RokokUtama/' . $rokok['image'] 
            ]);
        }

        // --- SNACK ---
        $daftarSnack = [
            ['brand' => 'mayora', 'name' => 'Waffello', 'price' => 9500, 'image' => '1._Wafello_Rp_9.500_per_pack_per_10_pc.png'],
            ['brand' => 'so-good', 'name' => 'Sonice', 'price' => 19000, 'image' => '2._Sonice_Rp_19.000_per_topless.png'], // Punya So Good
            ['brand' => 'mayora', 'name' => 'Astor', 'price' => 19000, 'image' => '3._Astor_Rp_19.000_per_box.png'],
            ['brand' => 'marie-regal', 'name' => 'Roti Regal', 'price' => 23000, 'image' => '4._Roti Regal_Rp_23.000_per_pc.png'],
            ['brand' => 'nissin', 'name' => 'Crispy Crackers', 'price' => 10000, 'image' => '5._Crispy_Crackers_Rp_10.000.png'],
            ['brand' => 'mayora', 'name' => 'Bang Bang Maxx', 'price' => 27000, 'image' => '6._Bang_Bang_Maxx_Rp_27.000.png'],
        ];

        foreach ($daftarSnack as $snack) {
            Product::firstOrCreate([
                'slug' => Str::slug($snack['name']),
            ], [
                'name' => $snack['name'],
                'category_id' => $catJajanan->id,
                'brand_id' => Brand::where('slug', $snack['brand'])->first()->id,
                'price' => $snack['price'],
                'stock' => 50,
                'description' => 'Jajanan lezat untuk menemani harimu.',
                'image_main' => 'products/SnackUtama/' . $snack['image'] 
            ]);
        }

        // --- MINUMAN ---
        $daftarMinuman = [
            ['brand' => 'danone', 'name' => 'Aqua 1.5L', 'price' => 5000, 'image' => '1._Aqua_1_5_liter_Rp_5.000_per_botol.png'],
            ['brand' => 'mayora', 'name' => 'Le Minerale 1.5L', 'price' => 5000, 'image' => '2._Le-Minerale_1_5_liter_Rp_5.000_per_botol.png'],
            ['brand' => 'coca-cola', 'name' => 'Coca Cola', 'price' => 5000, 'image' => '3._Coca_cola_seru_Rp_5.000_per_botol.png'],
            ['brand' => 'kino', 'name' => 'Larutan Cap Kaki Tiga', 'price' => 6000, 'image' => '4._Larutan_Cap_Kaki_Tiga_Kaleng_Rp_6.000.png'],
            ['brand' => 'otsuka', 'name' => 'Pocari Sweat 300ml', 'price' => 6500, 'image' => '6._Pocari_300_ml_harga_6.500_per_botol.png'],
            ['brand' => 'mayora', 'name' => 'Teh Pucuk Harum', 'price' => 3000, 'image' => '7._Teh_Pacuk_Harum_Rp_3.000.png'],
            ['brand' => 'nestle', 'name' => 'Nestle Carnation', 'price' => 14500, 'image' => '9._Nestle_Carnation_Rp14.500.png'],
            ['brand' => 'frisian-flag', 'name' => 'Frisian Flag SKM', 'price' => 11500, 'image' => '10._Frisian_Flag_Kental_Manis_11.500.png'],
            ['brand' => 'ultrajaya', 'name' => 'Ultra Milk Full Cream', 'price' => 5000, 'image' => '11._Ultra_Milk_Full_Cream_Rp_5.000.png'],
            ['brand' => 'sosro', 'name' => 'Teh Sosro Celup', 'price' => 5700, 'image' => '12._Sosro_30_teabag_Rp_5.700.png'],
            ['brand' => 'tong-tji', 'name' => 'Tong Tji Renceng', 'price' => 19500, 'image' => '13._Tongtji_renceng_19.500_per_rcg.png'],
            ['brand' => 'sido-muncul', 'name' => 'Susu Jahe Sido Muncul', 'price' => 17000, 'image' => '14._Susu_jahe_sidomuncul_17.000_per_rcg_per_10_pc.png'],
            ['brand' => 'kapal-api', 'name' => 'Kapal Api Special', 'price' => 52000, 'image' => '15._Kapal_api_380_gr_special_Rp_52.000.png'],
            ['brand' => 'kapal-api', 'name' => 'Good Day', 'price' => 15000, 'image' => '16._Goodday_Rp_15.000_per_rcg.png'],
            ['brand' => 'sari-incofood', 'name' => 'Indocafe Coffeemix', 'price' => 15500, 'image' => '17._Indocafe_Coffeemix_15.500_per_rcg.png'],
        ];

        foreach ($daftarMinuman as $minuman) {
            Product::firstOrCreate([
                'slug' => Str::slug($minuman['name']),
            ], [
                'name' => $minuman['name'],
                'category_id' => $catMinuman->id,
                'brand_id' => Brand::where('slug', $minuman['brand'])->first()->id,
                'price' => $minuman['price'],
                'stock' => 50,
                'description' => 'Minuman segar dan berkualitas.',
                'image_main' => 'products/DrinkUtama/' . $minuman['image'] 
            ]);
        }

        // --- SABUN ---
        $daftarSabun = [
            ['brand' => 'wings', 'name' => 'DIV Bar Soap', 'price' => 2900, 'image' => '1._DIV_Rp2.900_pc.png'],
            ['brand' => 'wings', 'name' => 'Claudia Bar Soap', 'price' => 2100, 'image' => '2._Claudia_Rp2.100_pc.png'],
            ['brand' => 'bkp', 'name' => 'Shinzui Bar Soap', 'price' => 4500, 'image' => '3._Shinzui_Rp4.500_pc.png'],
            ['brand' => 'unilever', 'name' => 'Lifebuoy Bar Soap', 'price' => 3200, 'image' => '4._Lifebuoy_Rp3.200_pc.png'],
            ['brand' => 'wings', 'name' => 'Nuvo Bar Soap', 'price' => 2900, 'image' => '5._Nuvo_Rp2.900_pc.png'],
            ['brand' => 'wings', 'name' => 'So Klin Liquid', 'price' => 4500, 'image' => '6._So-Klin_Liquid_Rp4.500.png'],
            ['brand' => 'unilever', 'name' => 'Rinso Detergent', 'price' => 2600, 'image' => '7._Rinso_Rp26.000.png'],
            ['brand' => 'unilever', 'name' => 'Sunlight', 'price' => 11000, 'image' => '8._Sunlight_Rp11.000.png'],
        ];

        foreach ($daftarSabun as $sabun) {
            Product::firstOrCreate([
                'slug' => Str::slug($sabun['name']),
            ], [
                'name' => $sabun['name'],
                'category_id' => $catSabun->id,
                'brand_id' => Brand::where('slug', $sabun['brand'])->first()->id,
                'price' => $sabun['price'],
                'stock' => 50,
                'description' => 'Kebersihan maksimal untuk keluarga.',
                'image_main' => 'products/SabunUtama/' . $sabun['image'] 
            ]);
        }

        // --- SEMBAKO ---
        $daftarSembako = [
            ['brand' => 'sinar-mas', 'name' => 'Minyak Mas 1L', 'price' => 17500, 'image' => '1._Minyak_mas_1liter_Rp_17.500_per_botol.png'],
            ['brand' => 'bkp', 'name' => 'Hemart 900ml', 'price' => 18500, 'image' => '2._Hemart_900_ml_18.500_per_pc.png'],
            ['brand' => 'bkp', 'name' => 'Hemart 500ml', 'price' => 11000, 'image' => '3._Hemart_500_ml_Rp_11.000_per_botol.png'],
            ['brand' => 'umum', 'name' => 'Beras C4 3kg', 'price' => 43500, 'image' => '4._Beras_C4_3_kg_Rp_43.500.png'],
            ['brand' => 'umum', 'name' => 'Beras Super 5kg', 'price' => 77500, 'image' => '5._Beras_super_5_kg_Rp77.500.png'],
            ['brand' => 'sugar-group', 'name' => 'Gulaku Premium', 'price' => 18000, 'image' => '6._Gulaku_Premium_Rp_18.000.png'],
        ];

        foreach ($daftarSembako as $sembako) {
            Product::firstOrCreate([
                'slug' => Str::slug($sembako['name']),
            ], [
                'name' => $sembako['name'],
                'category_id' => $catSembako->id,
                'brand_id' => Brand::where('slug', $sembako['brand'])->first()->id,
                'price' => $sembako['price'],
                'stock' => 50,
                'description' => 'Kebutuhan pokok berkualitas.',
                'image_main' => 'products/Sembako/' . $sembako['image'] 
            ]);
        }

        // ==========================================
        // 5. EMPLOYEE (TETAP SAMA)
        // ==========================================
        Employee::create([
            'name' => 'Ivan Purnomo',
            'position' => 'Owner (Pemilik)',
            'phone' => '085702328000',
            'image_photo' => 'Ivan_Purnomo_Liem.jpg', 
        ]);

        Employee::create([
            'name' => 'Kristiani Pudji Astuti',
            'position' => 'Co-Owner & Finance',
            'phone' => '083865802000',
            'image_photo' => 'Kristiani_Pudji_Astuti.jpg',
        ]);

        Employee::create([
            'name' => 'Lim Salim',
            'position' => 'Operational Manager',
            'phone' => '085104818000',
            'image_photo' => 'LimSalim.jpeg',
        ]);

        Employee::create([
            'name' => 'Mas Ndok',
            'position' => 'Employee',
            'phone' => '081329518800',
            'image_photo' => 'Mas_Ndok.jpeg',
        ]);

        Employee::create([
            'name' => 'Mas Sugik',
            'position' => 'Employee',
            'phone' => '085728644633',
            'image_photo' => 'Mas_Sugik.jpeg',
        ]);

        Employee::create([
            'name' => 'Mas Min',
            'position' => 'Employee',
            'phone' => '-',
            'image_photo' => 'Mas_Min.jpeg',
        ]);
        
        Employee::create([
            'name' => 'Pak Mbung',
            'position' => 'Employee',
            'phone' => '-',
            'image_photo' => 'Pak_Mbung.jpeg',
        ]);

        // Seed suppliers & restocks
        $this->call([
            \Database\Seeders\SupplierSeeder::class,
            \Database\Seeders\RestockSeeder::class,
        ]);
    }
}