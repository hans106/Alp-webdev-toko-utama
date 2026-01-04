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
            'name' => 'Iin Salim',
            'position' => 'Operational Manager',
            'phone' => '085104818000',
            'image_photo' => 'IimSalim.jpeg',
        ]);

        Employee::create([
            'name' => 'Tukiman',
            'position' => 'Employee',
            'phone' => '081329518800',
            'image_photo' => 'Mas_Ndok.jpeg',
        ]);

        Employee::create([
            'name' => 'Agus Pratolo',
            'position' => 'Employee',
            'phone' => '085728644633',
            'image_photo' => 'Mas_Sugik.jpeg',
        ]);

        Employee::create([
            'name' => 'Ngatmin',
            'position' => 'Employee',
            'phone' => '082313104656',
            'image_photo' => 'Mas_Min.jpeg',
        ]);
        
        Employee::create([
            'name' => 'Suradi Orick',
            'position' => 'Employee',
            'phone' => '081229757570',
            'image_photo' => 'Pak_Mbung.jpeg',
        ]);
    }
}