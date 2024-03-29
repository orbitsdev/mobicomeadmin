<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\QuestionNumber;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\NumberSeeder;
use Database\Seeders\ChapterSeeder;
use Database\Seeders\LessonNumberSeeder;
use Database\Seeders\ChapterNumberSeeder;
use Database\Seeders\QuestionNumberSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            SectionSeeder::class,
            ChapterSeeder::class,
            ChapterNumberSeeder::class,
            LessonNumberSeeder::class,
            QuestionNumberSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
