<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

uses(RefreshDatabase::class);

it('login a user', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'user' => [
                'id',
                'name',
                'email',
                'phone',
                'identity_card',
                'created_at',
                'updated_at',
            ],
            'token',
        ]);
});

it('registers a new user', function () {
    $response = $this->postJson('/api/v1/register', [
        'name' => 'Test User',
        'email' => 'testuser@example.com',
        'password' => 'password',
        'phone' => '1234567890',
        'identity_card' => 'ID123456',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'user' => [
                'id',
                'name',
                'email',
                'phone',
                'identity_card',
                'created_at',
                'updated_at',
            ],
            'token',
        ]);
});

