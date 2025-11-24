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

it('checks user cannot login with wrong email', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/v1/login', [
        'email' => 'testbad@example',
        'password' => 'password',
    ]);

    $response->assertStatus(422)
    ->assertJsonValidationErrors(['email']);
});

it('checks user cannot login with wrong password', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'wrongpassword',
    ]);

    $response->assertStatus(401)
    ->assertSeeText('The provided credentials are incorrect.');
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

it('log out a user', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $token = $response->json('token');

    $logoutResponse = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->postJson('/api/v1/logout');

    $logoutResponse->assertStatus(200)
        ->assertSeeText('Session Closed');
});

