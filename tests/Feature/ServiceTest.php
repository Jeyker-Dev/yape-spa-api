<?php

use App\Models\User;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can list services', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum');

    $response = $this->getJson('/api/v1/services');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'services' => [
                '*' => [
                    'id',
                    'name',
                    'duration_minutes',
                    'image',
                    'description',
                    'price',
                    'category_id',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
});

it('can create a service', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum');

    $category = Category::factory()->create();

    $response = $this->postJson('/api/v1/services', [
        'name' => 'Test Service',
        'duration_minutes' => 60,
        'image' => 'test-image.jpg',
        'description' => 'This is a test service.',
        'price' => 99.99,
        'category_id' => $category->id,
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'message',
            'service' => [
                'id',
                'name',
                'duration_minutes',
                'image',
                'description',
                'price',
                'category_id',
                'created_at',
                'updated_at',
            ],
        ]);

    $this->assertDatabaseHas('services', [
        'name' => 'Test Service',
        'duration_minutes' => 60,
        'image' => 'test-image.jpg',
        'description' => 'This is a test service.',
        'price' => 99.99,
        'category_id' => 1,
    ]);
});

it('can update a service', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum');

    $category = Category::factory()->create();

    $service = Service::factory()->create([
        'category_id' => $category->id,
    ]);

    $response = $this->putJson("/api/v1/services/{$service->id}", [
        'name' => 'Updated Service',
        'duration_minutes' => 90,
        'image' => 'updated-image.jpg',
        'description' => 'This is an updated test service.',
        'price' => 149.99,
        'category_id' => $category->id,
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'service' => [
                'id',
                'name',
                'duration_minutes',
                'image',
                'description',
                'price',
                'category_id',
                'created_at',
                'updated_at',
            ],
        ]);

    $this->assertDatabaseHas('services', [
        'id' => $service->id,
        'name' => 'Updated Service',
        'duration_minutes' => 90,
        'image' => 'updated-image.jpg',
        'description' => 'This is an updated test service.',
        'price' => 149.99,
        'category_id' => $category->id,
    ]);
});

it('can delete a service', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum');

    $category = Category::factory()->create();

    $service = Service::factory()->create([
        'category_id' => $category->id,
    ]);

    $response = $this->deleteJson("/api/v1/services/{$service->id}");

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Service deleted successfully.',
        ]);

    $this->assertDatabaseMissing('services', [
        'id' => $service->id,
    ]);
});
