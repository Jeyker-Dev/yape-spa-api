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

it('creates a new availability', function () {
    $user = User::factory()->create();

    $availabilityData = [
        'day_of_week' => 'Monday',
        'start_time' => '09:00:00',
        'end_time' => '17:00:00',
        'is_working' => true,
    ];

    $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/availabilities', $availabilityData);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'message',
            'availability' => ['id', 'day_of_week', 'start_time', 'end_time', 'is_working', 'created_at', 'updated_at']
        ]);

    $this->assertDatabaseHas('availabilities', $availabilityData);
});

it('validates availability creation request', function () {
    $user = User::factory()->create();

    $invalidData = [
        'day_of_week' => '',
        'start_time' => 'invalid-time',
        'end_time' => 'invalid-time',
        'is_working' => 'not-a-boolean',
    ];

    $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/availabilities', $invalidData);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['day_of_week', 'start_time', 'end_time', 'is_working']);
});

it('shows a specific availability', function () {
    $user = User::factory()->create();
    $availability = Availability::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->getJson("/api/v1/availabilities/{$availability->id}");

    $response->assertStatus(200)
        ->assertJsonStructure([
            'availability' => ['id', 'day_of_week', 'start_time', 'end_time', 'is_working', 'created_at', 'updated_at']
        ]);
});

it('updates an existing availability', function () {
    $user = User::factory()->create();
    $availability = Availability::factory()->create([
        'day_of_week' => 'Monday',
        'start_time' => '09:00:00',
        'end_time' => '17:00:00',
        'is_working' => true,
    ]);

    $updatedData = [
        'day_of_week' => 'Tuesday',
        'start_time' => '10:00:00',
        'end_time' => '18:00:00',
        'is_working' => false,
    ];

    $response = $this->actingAs($user, 'sanctum')->putJson("/api/v1/availabilities/{$availability->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'availability' => ['id', 'day_of_week', 'start_time', 'end_time', 'is_working', 'created_at', 'updated_at']
        ]);

    $this->assertDatabaseHas('availabilities', array_merge(['id' => $availability->id], $updatedData));
});

it('deletes an availability', function () {
    $user = User::factory()->create();
    $availability = Availability::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/v1/availabilities/{$availability->id}");

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Availability deleted successfully.'
        ]);

    $this->assertDatabaseMissing('availabilities', ['id' => $availability->id]);
});
