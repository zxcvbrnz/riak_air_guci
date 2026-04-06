<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArtisanSeeder extends Seeder
{
    public function run(): void
    {
        $artisans = [
            [
                'name' => 'Hj. Siti Mariam',
                'role_id' => 'Maestro Sulam Air Guci',
                'role_en' => 'Master of Air Guci Embroidery',
                'quote_id' => 'Setiap tusukan jarum adalah doa yang terjaga dalam helai benang emas.',
                'quote_en' => 'Every needle prick is a prayer kept within the strands of gold thread.',
                'description_id' => 'Telah mendedikasikan lebih dari 40 tahun hidupnya untuk melestarikan motif klasik Banua agar tidak lekang oleh waktu.',
                'description_en' => 'Has dedicated more than 40 years of her life to preserving classic Banua motifs so they remain timeless.',
                'photo' => 'artisans/hj-siti-mariam.jpg',
                'order' => 1,
            ],
            [
                'name' => 'Syarifah Aini',
                'role_id' => 'Penenun Warisan',
                'role_en' => 'Heritage Weaver',
                'quote_id' => 'Menjaga tradisi bukan berarti menolak modernitas, tapi memberi jiwa pada masa depan.',
                'quote_en' => 'Preserving tradition doesn’t mean rejecting modernity, but giving soul to the future.',
                'description_id' => 'Fokus pada pengembangan teknik pewarnaan alami yang ramah lingkungan namun tetap memancarkan kemewahan.',
                'description_en' => 'Focuses on developing eco-friendly natural dyeing techniques that still radiate luxury.',
                'photo' => 'artisans/syarifah-aini.jpg',
                'order' => 2,
            ],
        ];

        foreach ($artisans as $artisan) {
            DB::table('artisans')->insert(array_merge($artisan, [
                'slug' => Str::slug($artisan['name']), // Menghasilkan hj-siti-mariam
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
