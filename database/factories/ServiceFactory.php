<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'duration_minutes' => $this->faker->numberBetween(30, 180),
            'image' => $this->faker->imageUrl(640, 480, 'business', true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 20, 500),
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}
