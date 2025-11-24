<?php

use App\Models\Availability;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses (RefreshDatabase::class);

it('fetches the list of availabilities', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/availabilities');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'availabilities' => [
                '*' => ['id', 'day_of_week', 'start_time', 'end_time', 'is_working', 'created_at', 'updated_at']
            ]
        ]);
});
