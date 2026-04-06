<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MovementSchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools = [
            [
                'label_id' => 'Rangkai Ilmu',
                'label_en' => 'Education Series',
                'title_id' => 'Workshop SMKN 4 Banjarmasin',
                'title_en' => 'Workshop at SMKN 4 Banjarmasin',
                'description_id' => 'Memperkenalkan teknik sulam Air Guci kepada generasi muda kreatif di sekolah seni dan kriya.',
                'description_en' => 'Introducing Air Guci embroidery techniques to the creative young generation in art and craft schools.',
                'media_path' => 'movements/smkn4-workshop.jpg', // Pastikan file ada di storage
                'type' => 'image',
                'video_url' => null,
                'order' => 1,
            ],
            [
                'label_id' => 'Rangkai Ilmu',
                'label_en' => 'Education Series',
                'title_id' => 'Riak Goes to SMAN 1 Banjarbaru',
                'title_en' => 'Riak Goes to SMAN 1 Banjarbaru',
                'description_id' => 'Dokumentasi keseruan siswa-siswi SMAN 1 Banjarbaru saat mencoba menusukkan jarum emas pertama mereka.',
                'description_en' => 'Documentation of the excitement of SMAN 1 Banjarbaru students as they try their first golden needle stitch.',
                'media_path' => 'movements/sman1-thumbnail.jpg',
                'type' => 'video',
                'video_url' => 'https://www.youtube.com/watch?v=example1', // Ganti dengan link video asli
                'order' => 2,
            ],
            [
                'label_id' => 'Rangkai Ilmu',
                'label_en' => 'Education Series',
                'title_id' => 'Kunjungan Edukasi Maestro',
                'title_en' => 'Maestro Educational Visit',
                'description_id' => 'Mendekatkan siswa dengan sosok maestro sulam Air Guci untuk mendengar kisah di balik setiap motif.',
                'description_en' => 'Bringing students closer to the Air Guci embroidery maestros to hear the stories behind every motif.',
                'media_path' => 'movements/maestro-visit.jpg',
                'type' => 'image',
                'video_url' => null,
                'order' => 3,
            ],
            [
                'label_id' => 'Rangkai Ilmu',
                'label_en' => 'Education Series',
                'title_id' => 'Seni Banua di Mata Muda',
                'title_en' => 'Banua Art in Young Eyes',
                'description_id' => 'Video testimoni para siswa mengenai pentingnya menjaga warisan budaya sulam di era modern.',
                'description_en' => 'Testimonial video from students about the importance of preserving embroidery heritage in the modern era.',
                'media_path' => 'movements/testimony-thumbnail.jpg',
                'type' => 'video',
                'video_url' => 'https://www.youtube.com/watch?v=example2',
                'order' => 4,
            ],
        ];

        foreach ($schools as $school) {
            DB::table('movement_schools')->insert(array_merge($school, [
                'slug' => Str::slug($school['title_id']),
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
