<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InternalScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agendas = [
            [
                'title_id' => 'Workshop Sulam Dasar',
                'title_en' => 'Basic Embroidery Workshop',
                'date' => '2026-04-15',
                'location_id' => 'SMKN 4 Banjarmasin',
                'location_en' => 'SMKN 4 Banjarmasin',
                'is_completed' => false,
            ],
            [
                'title_id' => 'Sosialisasi Warisan Banua',
                'title_en' => 'Banua Heritage Socialization',
                'date' => '2026-04-20',
                'location_id' => 'SMAN 1 Banjarbaru',
                'location_en' => 'SMAN 1 Banjarbaru',
                'is_completed' => false,
            ],
        ];

        foreach ($agendas as $agenda) {
            \App\Models\InternalSchedule::create($agenda);
        }
    }
}
