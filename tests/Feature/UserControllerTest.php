<?php

use App\Models\User;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

it('lists all users', function () {
    User::factory()->count(50)->create();

    getJson('/users')
        ->assertOk()
        ->assertJsonCount(50, 'data')
        ->assertJsonStructure(['data' => [['id', 'name', 'email', 'created_at', 'updated_at']]]);
});

it('shows a single user', function () {
    $user = User::factory()->create();

    getJson("/users/$user->id")
        ->assertOk()
        ->assertJsonStructure(['id', 'name', 'email', 'created_at', 'updated_at'])
        ->assertJson(['id' => $user->id, 'name' => $user->name, 'email' => $user->email]);
});

it('creates a new user', function () {
    $userData = User::factory()->make()->toArray();

    postJson('/users', [...$userData, 'password' => 'secret'])
        ->assertCreated()
        ->assertJsonStructure(['id', 'name', 'email', 'created_at', 'updated_at'])
        ->assertJson(['name' => $userData['name'], 'email' => $userData['email']]);
});

it('updates an existing user', function () {
    $user = User::factory()->create();
    $updatedData = ['name' => fake()->name(), 'email' => fake()->unique()->safeEmail()];

    putJson("/users/$user->id", $updatedData)
        ->assertOk()
        ->assertJsonStructure(['id', 'name', 'email', 'created_at', 'updated_at'])
        ->assertJson(['id' => $user->id, 'name' => $updatedData['name'], 'email' => $updatedData['email']]);

    $user->refresh();
    expect($user->name)->toBe($updatedData['name'])
        ->and($user->email)->toBe($updatedData['email']);
});

it('deletes a user', function () {
    $user = User::factory()->create();

    getJson("/users/$user->id")->assertOk();

    deleteJson("/users/$user->id")->assertNoContent();

    expect(User::query()->find($user->id))->toBeNull();
});

