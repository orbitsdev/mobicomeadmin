<?php

namespace Database\Factories;

use App\Models\Chapter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
            'chapter_id' => Chapter::inRandomOrder()->firstOrFail()->id,
            'image_path' => $this->faker->url(),
            'video_path' => $this->faker->url(),
            'lesson_number' => $this->faker->numberBetween(1,99),
           
        ];
    }
}
