<?php

use App\Models\User;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can list payment methods', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');

    $response = $this->getJson('/api/v1/payment-methods');

    $response->assertStatus(200)
        ->assertJsonStructure(['payment_methods' => [
            '*' => ['id', 'name', 'image', 'description', 'created_at', 'updated_at']
        ]]);
});

it('can create a payment method', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');

    $data = [
        'name' => 'Credit Card',
        'image' => 'credit_card.png',
        'description' => 'Pay using credit card',
    ];

    $response = $this->postJson('/api/v1/payment-methods', $data);

    $response->assertStatus(201)
        ->assertJsonFragment(['name' => 'Credit Card']);
});

it('can show a payment method', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');

    $paymentMethod = PaymentMethod::factory()->create();

    $response = $this->getJson("/api/v1/payment-methods/{$paymentMethod->id}");

    $response->assertStatus(200)
        ->assertJsonFragment(['id' => $paymentMethod->id]);

    $this->assertDatabaseHas('payment_methods', ['id' => $paymentMethod->id]);
});

it('can update a payment method', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');

    $paymentMethod = PaymentMethod::factory()->create();

    $data = [
        'name' => 'Updated Name',
        'image' => 'updated_image.png',
        'description' => 'Updated description',
    ];

    $response = $this->putJson("/api/v1/payment-methods/{$paymentMethod->id}", $data);

    $response->assertStatus(200)
        ->assertJsonFragment(['name' => 'Updated Name']);

    $this->assertDatabaseHas('payment_methods', ['id' => $paymentMethod->id, 'name' => 'Updated Name']);
});

it('can delete a payment method', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');

    $paymentMethod = PaymentMethod::factory()->create();

    $response = $this->deleteJson("/api/v1/payment-methods/{$paymentMethod->id}");

    $response->assertStatus(200)
        ->assertJsonFragment(['message' => 'Payment method deleted successfully']);

    $this->assertDatabaseMissing('payment_methods', ['id' => $paymentMethod->id]);
});

