<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Availability>
 */
class AvailabilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'day_of_week' => $this->faker->dayOfWeek(),
            'start_time' => $this->faker->time('H:i:s', 'now'),
            'end_time' => $this->faker->time('H:i:s'),
            'is_working' => $this->faker->boolean,
        ];
    }
}
