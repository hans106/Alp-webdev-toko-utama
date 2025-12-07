<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // <--- WAJIB TAMBAH INI BUAT SLUG

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. User & Admin (Tetap sama)
        User::create([
            'name' => 'Admin',
            'email' => 'admin@tokoUtama.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Hansvere',
            'email' => 'hansvere@tokoUtama.com',
            'password' => Hash::make('hansvere123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Budi Pembeli',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // 2. Kategori (Tetap sama)
        Category::create(['name' => 'Sembako', 'slug' => 'sembako']);       // ID 1
        Category::create(['name' => 'Minuman', 'slug' => 'minuman']);       // ID 2
        Category::create(['name' => 'Jajanan', 'slug' => 'jajanan']);       // ID 3
        Category::create(['name' => 'Sabun', 'slug' => 'sabun']);           // ID 4
        Category::create(['name' => 'Rokok', 'slug' => 'rokok']);           // ID 5

        // 3. Brand (Tetap sama)
        Brand::create(['name' => 'Indofood', 'slug' => 'indofood']);     // ID 1
        Brand::create(['name' => 'Unilever', 'slug' => 'unilever']);     // ID 2
        Brand::create(['name' => 'Wings', 'slug' => 'wings']);           // ID 3
        Brand::create(['name' => 'Mayora', 'slug' => 'mayora']);         // ID 4
        Brand::create(['name' => 'Aneka Rokok', 'slug' => 'aneka-rokok']); // ID 5


        // --- INI BAGIAN LOOPINGNYA BANG (LEBIH RAPI) ---

        $daftarRokok = [
            ['name' => 'Dunhill Filter 16', 'price' => 32500, 'image' => '1._Dunhill_Filter16_Evoque_Rp_32.500.png'],
            ['name' => 'Dunhill Blue 20', 'price' => 28500, 'image' => '2._Dunhill_Blue_20_Rp_28.500.png'],
            ['name' => 'Dunhill Green 20', 'price' => 28500, 'image' => '3._Dunhill_Green_20_Rp_28.500.png'],
            ['name' => 'Lucky Strike Purple 20', 'price' => 30000, 'image' => '4._Lucky_Strike_Purple_20_Rp_30.000.png'],
            ['name' => 'Lucky Strike Cool Switch 20', 'price' => 30000, 'image' => '5._Lucky_Strike_Cool_Switch_20_Rp_30.000.png'],
            ['name' => 'Lucky Strike Red 20', 'price' => 29000, 'image' => '6._Lucky_Strike_Red_20_Rp_29.000.png'],
            ['name' => 'Dunhill Black 12', 'price' => 22000, 'image' => '7._Dunhill_Black_12_Rp_.22.000.png'],
            ['name' => 'Dunhill Black 16', 'price' => 30000, 'image' => '8._Dunhill_Black_16_Rp_30.000.png'],
            ['name' => 'Dunhill White 16', 'price' => 30000, 'image' => '9._Dunhill_White_16_Rp_30.000.png'],
            ['name' => 'Dunhill White 20', 'price' => 38000, 'image' => '10._Dunhill_White_20_Rp_38.000.png'],
            ['name' => 'Country Light 20', 'price' => 27000, 'image' => '11._Country_Light__20_Rp_27.000.png'],
            ['name' => 'Country Red 20', 'price' => 27000, 'image' => '12._Country_Red_20_Rp_27.000.png'],
            ['name' => 'Bentoel Sejati 12', 'price' => 9500, 'image' => '13._Bentoel_Sejati_12_Rp_9.500.png'],
            ['name' => 'Camel Purple 16', 'price' => 19500, 'image' => '14._Camel_Purple_16_Rp_19.500.png'],
            ['name' => 'Camel Purple 12', 'price' => 25500, 'image' => '15._Camel_Purple_12_Rp_25.500.png'],
            ['name' => 'Camel Connect 20', 'price' => 30000, 'image' => '16._Camel_Connect_20_Rp_30.000.png'],
            ['name' => 'Camel Blue 16', 'price' => 23000, 'image' => '17._Camel_Blue16_Rp_23.000.png'],
            ['name' => 'Camel Ice Red 16', 'price' => 25500, 'image' => '18._Camel_Ice_Red_16_Rp_25.500.png'],
            ['name' => 'Camel Kretek 12', 'price' => 25500, 'image' => '19._Camel_Kretek_12_Rp_14.000.png'],
            ['name' => 'Camel Kretek 16', 'price' => 25500, 'image' => '20._Camel_Kretek_16_Rp_25.500.png'],
            ['name' => 'Tenor Hijau 12', 'price' => 9500, 'image' => '21._Tenor_Hijau_12_Rp_9.500.png'],
            ['name' => 'Tenor Teh Manis 12', 'price' => 9500, 'image' => '22._Tenor_teh_manis_12_Rp_9.500.png'],
            ['name' => 'Viper Red 16', 'price' => 21000, 'image' => '23._Viper_Red_16_Rp_21.000.png'],
            ['name' => 'Djarum 76', 'price' => 16000, 'image' => '24._Djarum76_12_Rp_16.000.png'],
            ['name' => 'Djarum 76 Apel 12', 'price' => 14500, 'image' => '25._76_Apel_12_Rp_14.500.png'],
            ['name' => 'Djarum 76 Nanas 12', 'price' => 14500, 'image' => '26._Djarum76_Nanas_12_Rp_14.500.png'],
            ['name' => 'Djarum 76 Filter Gold', 'price' => 23000, 'image' => '27._Djarum_76_Filter_Gold_12_Rp_23.000.png'],
            ['name' => 'LA Ice 16', 'price' => 35000, 'image' => '28._LA_Ice_16_Rp_35.500.png'],
            ['name' => 'LA Mentol 16', 'price' => 35000, 'image' => '29._LA_Mentol_16__Rp_35.500.png'],
            ['name' => 'LA Light 16', 'price' => 33500, 'image' => '30._LA_Light_16_Rp_33.500.png'],
            ['name' => 'LA Bold 12', 'price' => 22500, 'image' => '31._LA_Bold_12_Rp_22.500.png'],
            ['name' => 'LA Bold 20', 'price' => 38000, 'image' => '32._LA_Bold_20_Rp_38.000.png'],
            ['name' => 'LA Bold 16', 'price' => 30000, 'image' => '33._LA_Bold_16_Rp30.0000.png'], 
        ];


        $daftarSnack = [
            ['name' => 'Wafello', 'price' => 9500, 'image' => '1._Wafello_Rp_9.500_per_pack_per_10_pc.png'],
            ['name' => 'Sonice', 'price' => 19000, 'image' => '2._Sonice_Rp_19.000_per_topless.png'],
            ['name' => 'Astor', 'price' => 19000, 'image' => '3._Astor_Rp_19.000_per_box.png'],
            ['name' => 'Roti Regal', 'price' => 23000, 'image' => '4._Roti Regal_Rp_23.000_per_pc.png'],
            ['name' => 'Crispy Crackers', 'price' => 10000, 'image' => '5._Crispy_Crackers_Rp_10.000.png'],
            ['name' => 'Bang Bang Maxx', 'price' => 27000, 'image' => '6._Bang_Bang_Maxx_Rp_27.000.png'],
        ];


        $daftarMinuman = [
            ['name' => 'Aqua', 'price' => 5000, 'image' => '1._Aqua_1_5_liter_Rp_5.000_per_botol.png'],
            ['name' => 'Le-Minerale', 'price' => 5000, 'image' => '2._Le-Minerale_1_5_liter_Rp_5.000_per_botol.png'],
            ['name' => 'Coca Cola', 'price' => 5000, 'image' => '3._Coca_cola_seru_Rp_5.000_per_botol.png'],
            ['name' => 'Larutan Cap Kaki Tiga Kaleng', 'price' => 6000, 'image' => '4._Larutan_Cap_Kaki_Tiga_Kaleng_Rp_6.000'],
            ['name' => 'Pocari 300 ml', 'price' => 6500, 'image' => '6._Pocari_300_ml_harga_6.500_per_botol.png'],
            ['name' => 'Teh Pacuk Harum', 'price' => 3000, 'image' => '7._Teh_Pacuk_Harum_Rp_3.000.png'],
            ['name' => 'Nestle Carnation', 'price' => 14500, 'image' => '9._Nestle_Carnation_Rp14.500.png'],
            ['name' => 'Frisian Flag', 'price' => 11500, 'image' => '10._Frisian_Flag_Kental_Manis_11.500.png'],
            ['name' => 'Ultra Milk', 'price' => 5000, 'image' => '11._Ultra_Milk_Full_Cream_Rp_5.000.png'],
            ['name' => 'Teh Sosro', 'price' => 5700, 'image' => '12._Sosro_30_teabag_Rp_5.700.png'],
            ['name' => 'Tongtji Renceng', 'price' => 19500, 'image' => '13._Tongtji_renceng_19.500_per_rcg.png'],
            ['name' => 'Susu Jahe', 'price' => 17000, 'image' => '14._Susu_jahe_sidomuncul_17.000_per_rcg_per_10_pc.png'],
            ['name' => 'Kapal Api', 'price' => 52000, 'image' => '15._Kapal_api_380_gr_special_Rp_52.000.png'],
            ['name' => 'Goodday', 'price' => 15000, 'image' => '16._Goodday_Rp_15.000_per_rcg.png'],
            ['name' => 'Indocafe Coffeemix', 'price' => 15500, 'image' => '17._Indocafe_Coffeemix_15.500_per_rcg.png'],
        ];

        $daftarSabun = [
            ['name' => 'DIV', 'price' => 2900, 'image' => '1._DIV_Rp2.900_pc.png'],
            ['name' => 'Claudia', 'price' => 2100, 'image' => '2._Claudia_Rp2.100_pc.png'],
            ['name' => 'Shinzui', 'price' => 4500, 'image' => '3._Shinzui_Rp4.500_pc.png'],
            ['name' => 'Lifebuoy', 'price' => 3200, 'image' => '4._Lifebuoy_Rp3.200_pc.png'],
            ['name' => 'Nuvo', 'price' => 2900, 'image' => '5._Nuvo_Rp2.900_pc.png'],
            ['name' => 'So Klin', 'price' => 4500, 'image' => '6._So-Klin_Liquid_Rp4.500.png'],
            ['name' => 'Rinso', 'price' => 2600, 'image' => '7._Rinso_Rp26.000.png'],
            ['name' => 'Sunlight', 'price' => 11000, 'image' => '8._Sunlight_Rp11.000.png'],
        ];

        $daftarSembako = [
            ['name' => 'Minyak Mas', 'price' => 17500, 'image' => '1._Minyak_mas_1liter_Rp_17.500_per_botol.png'],
            ['name' => 'Hemart 900 ml', 'price' => 18500, 'image' => '2._Hemart_900_ml_18.500_per_pc.png'],
            ['name' => 'Hemart 500 ml', 'price' => 11000, 'image' => '3._Hemart_500_ml_Rp_11.000_per_botol.png'],
            ['name' => 'Beras C4 3 kg', 'price' => 43500, 'image' => '4._Beras_C4_3_kg_Rp_43.500.png'],
            ['name' => 'Beras Super 5 kg', 'price' => 77500, 'image' => '5._Beras_super_5_kg_Rp77.500.png'],
            ['name' => 'Gulaku Premium', 'price' => 18000, 'image' => '6._Gulaku_Premium_Rp_18.000.png'],
        ];


        foreach ($daftarRokok as $rokok) {
            Product::create([
                'name' => $rokok['name'],
                'slug' => Str::slug($rokok['name']), // Otomatis bikin slug
                'category_id' => 5, // Masuk Kategori Rokok
                'brand_id' => 5,    // Masuk Brand Aneka Rokok
                'price' => $rokok['price'],
                'stock' => 50,
                'description' => 'Peringatan: Rokok mengandung zat adiktif yang berbahaya bagi kesehatan.',
                // Saya tambahkan 'products/' biar otomatis nyambung ke folder yang tadi
                'image' => 'products/RokokUtama/' . $rokok['image'] 
            ]);
        }
        foreach ($daftarSnack as $snack) {
            Product::create([
                'name' => $snack['name'],
                'slug' => Str::slug($snack['name']), // Otomatis bikin slug
                'category_id' => 3, // Masuk Kategori Jajanan
                'brand_id' => 4,    // Masuk Brand Mayora
                'price' => $snack['price'],
                'stock' => 50,
                'description' => 'Nikmati lezatnya jajanan dari Mayora yang menggugah selera.',
                // Saya tambahkan 'products/' biar otomatis nyambung ke folder yang tadi
                'image' => 'products/SnackUtama/' . $snack['image'] 
            ]);
        }

        foreach ($daftarMinuman as $minuman) {
            Product::create([
                'name' => $minuman['name'],
                'slug' => Str::slug($minuman['name']), // Otomatis bikin slug
                'category_id' => 2, // Masuk Kategori Minuman
                'brand_id' => 1,    // Masuk Brand Indofood
                'price' => $minuman['price'],
                'stock' => 50,
                'description' => 'Segarkan harimu dengan minuman berkualitas dari Indofood.',
                // Saya tambahkan 'products/' biar otomatis nyambung ke folder yang tadi
                'image' => 'products/DrinkUtama/' . $minuman['image'] 
            ]);
        }

        foreach ($daftarSabun as $sabun) {
            Product::create([
                'name' => $sabun['name'],
                'slug' => Str::slug($sabun['name']), // Otomatis bikin slug
                'category_id' => 4, // Masuk Kategori Sabun
                'brand_id' => 2,    // Masuk Brand Unilever
                'price' => $sabun['price'],
                'stock' => 50,
                'description' => 'Rasakan kesegaran dan kebersihan maksimal dengan sabun pilihan dari Unilever.',
                // Saya tambahkan 'products/' biar otomatis nyambung ke folder yang tadi
                'image' => 'products/SabunUtama/' . $sabun['image'] 
            ]);
        }

        foreach ($daftarSembako as $sembako) {
            Product::create([
                'name' => $sembako['name'],
                'slug' => Str::slug($sembako['name']), // Otomatis bikin slug
                'category_id' => 1, // Masuk Kategori Sembako
                'brand_id' => 3,    // Masuk Brand Wings
                'price' => $sembako['price'],
                'stock' => 50,
                'description' => 'Lengkapi kebutuhan pokokmu dengan produk sembako berkualitas dari Wings.',
                // Saya tambahkan 'products/' biar otomatis nyambung ke folder yang tadi
                'image' => 'products/Sembako/' . $sembako['image'] 
            ]);
        }
        
    }
}