<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// For downloading placeholder images when source images are not present
use Illuminate\Support\Str;

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
                'image' => '2.Gala_Dinner_Best_Outlet_Omah_Sinten_Solo_15_April_2011.jpeg',
                'description' => 'Momen kebersamaan apresiasi outlet terbaik di Omah Sinten.'
            ],
            [
                'title' => 'Customer Loyalty Program',
                'location' => 'Karanganyar',
                'event_date' => '2006-08-09', // Sesuai nama file (9-11 Agustus)
                'image' => '3.Customer_Loyalty_Program_9-11_Agustus_2006.jpeg',
                'description' => 'Program loyalitas pelanggan yang berlangsung meriah selama 3 hari.'
            ],
            [
                'title' => 'Gala Dinner Promild Tour (Guest: Changcuters & Armada)',
                'location' => 'Solo',
                'event_date' => '2012-09-21', // Sesuai nama file
                'image' => '5.Galadinner_Promild_Tour_2012_Changcuters_dan_Armada_21_September_2012.jpeg',
                'description' => 'Konser dan makan malam spesial bersama bintang tamu Changcuters & Armada.'
            ],
            [
                'title' => 'Surya Profesional Mild Tour',
                'location' => 'Solo',
                'event_date' => '2011-06-01', // Estimasi pertengahan tahun 2011
                'image' => '4.Surya_Profesional_Mild_Tour_2011_Gala_Dinner_Bersama_SA_GG_SOLO.jpeg',
                'description' => 'Gala Dinner bersama SA GG Solo dalam rangkaian Surya Pro Tour.'
            ],
            [
                'title' => 'Amo Solo Wholesaler Class Family',
                'location' => 'Solo',
                'event_date' => '2013-05-20', // Tanggal dummy (karena di file gak ada tanggal)
                'image' => '6.Amo_Solo_Wholesealer_Class_Family.jpeg',
                'description' => 'Gathering kekeluargaan bersama para grosir (Wholesaler).'
            ],
            [
                'title' => 'Event Gathering Utama',
                'location' => 'Internal',
                'event_date' => '2010-01-01', 
                'image' => '1.Event_1.jpeg',
                'description' => 'Dokumentasi kegiatan internal Toko Utama.'
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);

            // Ensure the image file exists in storage/app/public/events.
            // If not present, generate/download a placeholder (ui-avatars) and save with the seeded filename.
            if (! empty($event['image'])) {
                $dir = storage_path('app/public/events');
                if (! is_dir($dir)) {
                    Storage::disk('public')->makeDirectory('events');
                }

                $target = $dir . DIRECTORY_SEPARATOR . $event['image'];
                if (! file_exists($target)) {
                    // Build a placeholder URL using the event title (fallback)
                    $nameForUrl = isset($event['title']) ? urlencode($event['title']) : 'Event';
                    $placeholder = "https://ui-avatars.com/api/?name={$nameForUrl}&background=111827&color=fff&size=1024";

                    try {
                        $img = @file_get_contents($placeholder);
                        if ($img) {
                            file_put_contents($target, $img);
                        }
                    } catch (\Exception $e) {
                        // ignore failure to download; views will fallback to generated avatars
                    }
                }
            }
        }
    }
}