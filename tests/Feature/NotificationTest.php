<?php

use App\Models\User;
use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can list notifications', function () {
    User::factory()->create();
    $response = $this->actingAs(User::first())->getJson('/api/v1/notifications');

    $response->assertStatus(200)
        ->assertJsonStructure(['notifications' => [
            '*' => [
                'id',
                'user_id',
                'appointment_id',
                'type',
                'message',
                'sent_at',
                'is_new',
                'is_read',
                'created_at',
                'updated_at',
            ],
        ]]);
});

it('can show a notification', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');

    $appointment = Appointment::factory()->create();

    $notification = Notification::create([
        'user_id' => $user->id,
        'appointment_id' => $appointment->id,
        'type' => 'reminder',
        'message' => 'Your appointment is coming up.',
        'is_new' => true,
        'is_read' => false,
    ]);

    $response = $this->getJson("/api/v1/notifications/{$notification->id}");

    $response->assertStatus(200)
        ->assertJsonFragment([
            'id' => $notification->id,
            'user_id' => $notification->user_id,
            'appointment_id' => $notification->appointment_id,
            'type' => 'reminder',
            'message' => 'Your appointment is coming up.',
            'is_new' => 1,
            'is_read' => 0,
        ]);
});

it('can create a notification', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum');

    $appointment = Appointment::factory()->create();

    $notificationData = [
        'user_id' => $user->id,
        'appointment_id' => $appointment->id,
        'type' => 'reminder',
        'message' => 'Your appointment is coming up.',
        'sent_at' => now()->toDateTimeString(),
        'is_new' => true,
        'is_read' => false,
    ];

    $response = $this->postJson('/api/v1/notifications', $notificationData);

    $response->assertStatus(201)
        ->assertJsonFragment([
            'user_id' => $user->id,
            'appointment_id' => $appointment->id,
            'type' => 'reminder',
            'message' => 'Your appointment is coming up.',
            'is_new' => true,
            'is_read' => false,
        ]);

    $this->assertDatabaseHas('notifications', [
        'user_id' => $user->id,
        'appointment_id' => $appointment->id,
        'type' => 'reminder',
        'message' => 'Your appointment is coming up.',
        'is_new' => true,
        'is_read' => false,
    ]);
});

it('can update a notification', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');

    $appointment = Appointment::factory()->create();

    $notification = Notification::create([
        'user_id' => $user->id,
        'appointment_id' => $appointment->id,
        'type' => 'reminder',
        'message' => 'Your appointment is coming up.',
        'is_new' => true,
        'is_read' => false,
    ]);

    $updateData = [
        'user_id' => $user->id,
        'appointment_id' => $appointment->id,
        'type' => 'update',
        'message' => 'Your appointment has been rescheduled.',
        'sent_at' => now()->toDateTimeString(),
        'is_new' => false,
        'is_read' => true,
    ];

    $response = $this->putJson("/api/v1/notifications/{$notification->id}", $updateData);

    $response->assertStatus(200)
        ->assertJsonFragment([
            'id' => $notification->id,
            'type' => 'update',
            'message' => 'Your appointment has been rescheduled.',
            'is_new' => false,
            'is_read' => true,
        ]);

    $this->assertDatabaseHas('notifications', [
        'id' => $notification->id,
        'type' => 'update',
        'message' => 'Your appointment has been rescheduled.',
        'is_new' => false,
        'is_read' => true,
    ]);
});

it('deletes a notification', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');

    $appointment = Appointment::factory()->create();

    $notification = Notification::create([
        'user_id' => $user->id,
        'appointment_id' => $appointment->id,
        'type' => 'reminder',
        'message' => 'Your appointment is coming up.',
        'is_new' => true,
        'is_read' => false,
    ]);

    $response = $this->deleteJson("/api/v1/notifications/{$notification->id}");

    $response->assertStatus(200)
        ->assertJsonFragment([
            'message' => 'Notification deleted successfully',
        ]);

    $this->assertDatabaseMissing('notifications', [
        'id' => $notification->id,
    ]);
});
