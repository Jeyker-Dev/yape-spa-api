<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Appointment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'appointment_id' => Appointment::factory(),
            'type' => $this->faker->randomElement(['reminder', 'confirmation', 'cancellation']),
            'message' => $this->faker->sentence(),
            'sent_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'is_new' => $this->faker->boolean(70),
            'is_read' => $this->faker->boolean(50),
        ];
    }
}
