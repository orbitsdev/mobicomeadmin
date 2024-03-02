<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            'BSIT 1B', 'BSIT 1A', 'BSIT 1C', 'BSIT 1D',
            'BSIT 2B', 'BSIT 2A', 'BSIT 2C', 'BSIT 2D',
            'BSIT 3B', 'BSIT 3A', 'BSIT 3C', 'BSIT 3D',
        ];

        foreach ($sections as $section) {
            Section::create([
                'title'=> $section,
            ]);
        }
    }
}
