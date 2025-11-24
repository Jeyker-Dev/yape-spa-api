<?php

use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('fetches categories for authenticated user', function () {
    $user = User::factory()->create();
    Category::factory()->count(3)->create();

    $this->actingAs($user, 'sanctum');

    $response = $this->getJson('/api/v1/categories');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'categories' => [
                '*' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
});

it('creates a new category', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum');

    $response = $this->postJson('/api/v1/categories', [
        'name' => 'New Category',
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'message',
            'category' => [
                'id',
                'name',
                'created_at',
                'updated_at',
            ],
        ]);
});

it('validates category creation request', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum');

    $response = $this->postJson('/api/v1/categories', [
        'name' => '',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['name']);
});

it('updates an existing category', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create(['name' => 'Old Name']);

    $this->actingAs($user, 'sanctum');

    $response = $this->putJson("/api/v1/categories/{$category->id}", [
        'name' => 'Updated Name',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'category' => [
                'id',
                'name',
                'created_at',
                'updated_at',
            ],
        ]);
});

it('deletes an existing category', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $this->actingAs($user, 'sanctum');

    $response = $this->deleteJson("/api/v1/categories/{$category->id}");

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Category deleted successfully.',
        ]);
});
