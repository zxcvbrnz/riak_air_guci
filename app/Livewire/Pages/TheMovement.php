<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class TheMovement extends Component
{
    public function render()
    {
        $schools = collect([
            (object)[
                'id' => 1,
                'type' => 'video',
                'label' => 'Workshop',
                'title' => 'SMKN 4 Banjarmasin',
                'media_path' => 'movement/school-1.jpg', // Ganti dengan path foto Anda
                'description' => 'Mengenalkan teknik sulam dasar kepada siswa tata busana untuk regenerasi pengrajin.'
            ],
            (object)[
                'id' => 2,
                'type' => 'image',
                'label' => 'Sosialisasi',
                'title' => 'SMA Katolik Santo Paulus',
                'media_path' => 'movement/school-2.jpg',
                'description' => 'Edukasi sejarah sulam Air Guci sebagai warisan budaya tak benda dari Kalimantan Selatan.'
            ],
            (object)[
                'id' => 3,
                'type' => 'image',
                'label' => 'Cultural Day',
                'title' => 'SMP N 1 Banjarmasin',
                'media_path' => 'movement/school-3.jpg',
                'description' => 'Pameran hasil karya siswa dalam memanfaatkan limbah kain menjadi aksesoris bernilai seni.'
            ],
        ]);

        $artisans = collect([
            (object)[
                'id' => 1,
                'name' => 'Ibu Hajah Maryam',
                'role' => 'Maestro Sulam Air Guci',
                'photo' => 'movement/maestro-1.jpg',
                'quote' => 'Setiap tarikan benang emas adalah doa agar tradisi ini tidak pernah putus ditelan zaman.',
            ],
            (object)[
                'id' => 1,
                'name' => 'Ibu Hajah Maryam',
                'role' => 'Maestro Sulam Air Guci',
                'photo' => 'movement/maestro-1.jpg',
                'quote' => 'Setiap tarikan benang emas adalah doa agar tradisi ini tidak pernah putus ditelan zaman.',
            ],
            (object)[
                'id' => 1,
                'name' => 'Ibu Hajah Maryam',
                'role' => 'Maestro Sulam Air Guci',
                'photo' => 'movement/maestro-1.jpg',
                'quote' => 'Setiap tarikan benang emas adalah doa agar tradisi ini tidak pernah putus ditelan zaman.',
            ],
            (object)[
                'id' => 1,
                'name' => 'Ibu Hajah Maryam',
                'role' => 'Maestro Sulam Air Guci',
                'photo' => 'movement/maestro-1.jpg',
                'quote' => 'Setiap tarikan benang emas adalah doa agar tradisi ini tidak pernah putus ditelan zaman.',
            ],
            (object)[
                'id' => 2,
                'name' => 'Tim Pusaka Banua',
                'role' => 'Innovation & Design Team',
                'photo' => 'movement/team-innovation.jpg',
                'quote' => 'Kami mengolah limbah tekstil premium menjadi kanvas baru bagi keindahan sulam tradisional.',
            ]
        ]);

        return view('livewire.pages.the-movement', [
            'schools' => $schools,
            'artisans' => $artisans
        ]);
    }
}