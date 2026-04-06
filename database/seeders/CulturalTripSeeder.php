<?php

namespace Database\Seeders;

use App\Models\CulturalTrip;
use App\Models\TripBatch;
use App\Models\TripRute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CulturalTripSeeder extends Seeder
{
    public function run(): void
    {
        // --- TRIP 1: EKSPEDISI BENANG EMAS ---
        $title1 = 'Ekspedisi Benang Emas';
        $trip1 = CulturalTrip::create([
            'slug' => Str::slug($title1),
            'title_id' => $title1,
            'title_en' => 'The Gold Thread Expedition',
            'duration' => '3D 2N',
            'price_display' => '2.850k',
            'description_id' => 'Menyusuri tepian sungai Martapura untuk menemukan rahasia di balik kilaunya Sulam Air Guci langsung dari sang maestro.',
            'description_en' => 'Traversing the Martapura riverbanks to discover the secrets behind the shimmer of Air Guci embroidery directly from the maestro.',
            'image' => 'trips/gold-expedition.jpg',
        ]);

        // Rute Trip 1
        $rutes1 = [
            [
                'title_id' => 'Penyambutan & Filosofi Motif',
                'title_en' => 'Welcome & Motif Philosophy',
                'description_id' => 'Sesi perkenalan mendalam mengenai sejarah Air Guci di kediaman maestro.',
                'description_en' => 'In-depth introductory session about the history of Air Guci at the maestro\'s residence.',
                'order' => 1
            ],
            [
                'title_id' => 'Workshop Menyulam Privat',
                'title_en' => 'Private Embroidery Workshop',
                'description_id' => 'Praktik langsung membuat motif dasar menggunakan benang emas asli.',
                'description_en' => 'Hands-on practice creating basic motifs using authentic gold thread.',
                'order' => 2
            ],
            [
                'title_id' => 'Tur Galeri & Perpisahan',
                'title_en' => 'Gallery Tour & Farewell',
                'description_id' => 'Melihat koleksi antik dan penutupan perjalanan dengan jamuan khas Banjar.',
                'description_en' => 'Viewing antique collections and closing the journey with a signature Banjar banquet.',
                'order' => 3
            ],
        ];

        foreach ($rutes1 as $r) {
            TripRute::create(array_merge($r, ['cultural_trip_id' => $trip1->id]));
        }

        // Batch Trip 1
        TripBatch::create(['cultural_trip_id' => $trip1->id, 'departure_date' => '2026-06-15', 'available_seats' => 6]);
        TripBatch::create(['cultural_trip_id' => $trip1->id, 'departure_date' => '2026-08-20', 'available_seats' => 10]);


        // --- TRIP 2: SUSUR SUNGAI MARTAPURA ---
        $title2 = 'Susur Sungai Martapura';
        $trip2 = CulturalTrip::create([
            'slug' => Str::slug($title2),
            'title_id' => $title2,
            'title_en' => 'Martapura River Heritage',
            'duration' => '2D 1N',
            'price_display' => '1.750k',
            'description_id' => 'Merasakan ritme kehidupan sungai sambil mengunjungi sentra kerajinan tradisional yang legendaris.',
            'description_en' => 'Experience the rhythm of river life while visiting legendary traditional craft centers.',
            'image' => 'trips/river-heritage.jpg',
        ]);

        // Rute Trip 2
        $rutes2 = [
            [
                'title_id' => 'Pasar Terapung & Sarapan Tradisional',
                'title_en' => 'Floating Market & Traditional Breakfast',
                'description_id' => 'Memulai pagi di atas perahu (jukung) sambil menikmati kuliner khas sungai.',
                'description_en' => 'Starting the morning on a boat (jukung) while enjoying river-side culinary delights.',
                'order' => 1
            ],
            [
                'title_id' => 'Ziarah Budaya & Sentra Kerajinan',
                'title_en' => 'Cultural Pilgrimage & Craft Centers',
                'description_id' => 'Mengunjungi situs sejarah dan melihat proses pembuatan kain Sasirangan.',
                'description_en' => 'Visiting historical sites and witnessing the making process of Sasirangan cloth.',
                'order' => 2
            ],
        ];

        foreach ($rutes2 as $r) {
            TripRute::create(array_merge($r, ['cultural_trip_id' => $trip2->id]));
        }

        // Batch Trip 2
        TripBatch::create(['cultural_trip_id' => $trip2->id, 'departure_date' => '2026-07-10', 'available_seats' => 15]);
        TripBatch::create(['cultural_trip_id' => $trip2->id, 'departure_date' => '2026-09-05', 'available_seats' => 12]);
    }
}
