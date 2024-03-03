<?php

namespace Database\Seeders;

use App\Models\LessonNumber;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $numbers = [];
        for ($i = 1; $i <= 100; $i++) {
            $numbers[] = $i;
        }


        foreach ($numbers as $number) {
            LessonNumber::create([
                'number' => $number,
            ]);
        }
    }
}
