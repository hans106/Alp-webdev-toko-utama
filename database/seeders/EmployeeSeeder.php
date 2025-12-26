<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        // COPY DARI DATABASE SEEDER ABANG TADI
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
    }
}