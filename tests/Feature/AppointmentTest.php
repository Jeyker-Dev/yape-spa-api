<?php

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can list appointments', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');

    $response = $this->getJson('/api/v1/appointments');

    $response->assertStatus(200)
    ->assertJsonStructure([
        'appointments' => [
            '*' => [
                'id',
                'user_id',
                'start_time',
                'end_time',
                'status',
                'created_at',
                'updated_at',
            ],
        ],
    ]);
});

it('can show an appointment', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');

    $appointment = Appointment::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->getJson("/api/v1/appointments/{$appointment->id}");

    $response->assertStatus(200)
    ->assertJsonFragment([
        'id' => $appointment->id,
        'user_id' => $user->id,
    ]);
});

it('can create an appointment', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');

    $appointmentData = [
        'user_id' => $user->id,
        'start_time' => now()->format('H:i:s'),
        'end_time' => now()->addHour()->format('H:i:s'),
        'status' => 'scheduled',
    ];

    $response = $this->postJson('/api/v1/appointments', $appointmentData);

    $response->assertStatus(201)
    ->assertJsonFragment([
        'user_id' => $user->id,
        'start_time' => $appointmentData['start_time'],
        'end_time' => $appointmentData['end_time'],
        'status' => $appointmentData['status'],
    ]);
});

it('can update an appointment', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');

    $appointment = Appointment::factory()->create([
        'user_id' => $user->id,
    ]);

    $updatedData = [
        'user_id' => $user->id,
        'start_time' => now()->addHours(2)->format('H:i:s'),
        'end_time' => now()->addHours(3)->format('H:i:s'),
        'status' => 'completed',
    ];

    $response = $this->putJson("/api/v1/appointments/{$appointment->id}", $updatedData);

    $response->assertStatus(200)
    ->assertJsonFragment([
        'id' => $appointment->id,
        'user_id' => $user->id,
        'start_time' => $updatedData['start_time'],
        'end_time' => $updatedData['end_time'],
        'status' => $updatedData['status'],
    ]);
});

it('can delete an appointment', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');

    $appointment = Appointment::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->deleteJson("/api/v1/appointments/{$appointment->id}");

    $response->assertStatus(200)
    ->assertJsonFragment([
        'message' => 'Appointment deleted successfully',
    ]);
});
