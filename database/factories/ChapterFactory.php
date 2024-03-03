<?php

namespace Database\Factories;

use App\Models\Chapter;
use App\Models\ChapterNumber;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chapter>
 */
class ChapterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name(),
            'description' => $this->faker->sentence(),
            'chapter_number' => $this->faker->numberBetween(1, 99),
            'chapter_number_id' => function () {
                return ChapterNumber::factory()->create()->id;
            },
        ];
    }

    /**
     * Ensure the chapter_number_id is unique.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function configure()
    {
        return $this->afterMaking(function (Chapter $chapter) {
            $chapter->chapter_number_id = ChapterNumber::factory()->create()->id;
        });
    }
}
