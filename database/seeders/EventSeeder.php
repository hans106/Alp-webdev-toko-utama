<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    public function run()
    {
        // Kosongkan tabel dulu biar gak dobel kalau di-run berkali-kali
        DB::table('events')->truncate();

        $events = [
            [
                'title' => 'Gala Dinner Best Outlet',
                'location' => 'Omah Sinten, Solo',
                'event_date' => '2011-04-15', // Sesuai nama file
                'image' => 'Event/2. Gala Dinner Best Outlet-Omah Sinten Solo 15 April 2011.jpeg',
                'description' => 'Momen kebersamaan apresiasi outlet terbaik di Omah Sinten.'
            ],
            [
                'title' => 'Customer Loyalty Program',
                'location' => 'Karanganyar',
                'event_date' => '2006-08-09', // Sesuai nama file (9-11 Agustus)
                'image' => 'Event/3. Customer Loyalty Program 9-11 Agustus 2006.jpeg',
                'description' => 'Program loyalitas pelanggan yang berlangsung meriah selama 3 hari.'
            ],
            [
                'title' => 'Gala Dinner Promild Tour (Guest: Changcuters & Armada)',
                'location' => 'Solo',
                'event_date' => '2012-09-21', // Sesuai nama file
                'image' => 'Event/5. Galadinner Promild Tour 2012 Changcuters dan Armada 21 September 2012.jpeg',
                'description' => 'Konser dan makan malam spesial bersama bintang tamu Changcuters & Armada.'
            ],
            [
                'title' => 'Surya Profesional Mild Tour',
                'location' => 'Solo',
                'event_date' => '2011-06-01', // Estimasi pertengahan tahun 2011
                'image' => 'Event/4. Surya Profesional Mild Tour 2011 Gala Dinner Bersama SA GG SOLO.jpeg',
                'description' => 'Gala Dinner bersama SA GG Solo dalam rangkaian Surya Pro Tour.'
            ],
            [
                'title' => 'Amo Solo Wholesaler Class Family',
                'location' => 'Solo',
                'event_date' => '2013-05-20', // Tanggal dummy (karena di file gak ada tanggal)
                'image' => 'Event/6. Amo Solo Wholesealer Class Family.jpeg',
                'description' => 'Gathering kekeluargaan bersama para grosir (Wholesaler).'
            ],
            [
                'title' => 'Event Gathering Utama',
                'location' => 'Internal',
                'event_date' => '2010-01-01', 
                'image' => 'Event/1. Event 1.jpeg',
                'description' => 'Dokumentasi kegiatan internal Toko Utama.'
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}