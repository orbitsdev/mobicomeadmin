<?php

namespace Database\Seeders;

use App\Models\Number;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NumberSeeder extends Seeder
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
            Number::create([
                'number' => $number,
            ]);
        }
    }
}
