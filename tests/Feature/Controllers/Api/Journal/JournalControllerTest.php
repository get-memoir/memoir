<?php

declare(strict_types=1);

use App\Models\Journal;
use App\Models\Organization;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Sanctum\Sanctum;

$collectionJsonStructure = [
    'data' => [
        '*' => [
            'type',
            'id',
            'attributes' => [
                'name',
                'slug',
                'avatar',
                'created_at',
                'updated_at',
            ],
            'links' => [
                'self',
            ],
        ],
    ],
];

$singleJsonStructure = [
    'data' => [
        'type',
        'id',
        'attributes' => [
            'name',
            'slug',
            'avatar',
            'created_at',
            'updated_at',
        ],
        'links' => [
            'self',
        ],
    ],
];

it('can list the journals of the current user', function () use ($collectionJsonStructure): void {
    $user = User::factory()->create();

    $lifeJournal = Journal::factory()->create(['name' => 'Life', 'user_id' => $user->id]);
    $workJournal = Journal::factory()->create(['name' => 'Work', 'user_id' => $user->id]);

    Sanctum::actingAs($user);

    $response = $this->json('GET', '/api/journals');

    $response->assertStatus(200);
    $response->assertJsonStructure($collectionJsonStructure);
    $response->assertJsonCount(2, 'data');

    $response->assertJson([
        'data' => [
            [
                'type' => 'journal',
                'id' => (string) $lifeJournal->id,
                'attributes' => [
                    'name' => 'Life',
                    'slug' => $lifeJournal->slug,
                ],
            ],
            [
                'type' => 'journal',
                'id' => (string) $workJournal->id,
                'attributes' => [
                    'name' => 'Work',
                    'slug' => $workJournal->slug,
                ],
            ],
        ],
    ]);
});

it('returns empty collection when user has no journals', function () use ($collectionJsonStructure): void {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $response = $this->json('GET', '/api/journals');

    $response->assertStatus(200);
    $response->assertJsonStructure($collectionJsonStructure);
    $response->assertJsonCount(0, 'data');
});

it('can create a new journal', function () use ($singleJsonStructure): void {
    Carbon::setTestNow('2025-01-01 00:00:00');
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $response = $this->json('POST', '/api/journals', [
                'name' => 'Life',
    ]);

    $response->assertStatus(201);
    $response->assertJsonStructure($singleJsonStructure);

    $this->assertDatabaseHas('journals', [
        'name' => 'Life',
    ]);

    $journal = Journal::where('name', 'Life')->first();

    $response->assertJson([
        'data' => [
            'type' => 'journal',
            'id' => (string) $journal->id,
            'attributes' => [
                'name' => 'Life',
                'slug' => $journal->slug,
                'created_at' => 1735689600,
                'updated_at' => 1735689600,
            ],
        ],
    ]);
});

it('can show a journal', function () use ($singleJsonStructure): void {
    $user = User::factory()->create();
    $journal = Journal::factory()->create([
        'user_id' => $user->id,
    ]);

    Sanctum::actingAs($user);

    $response = $this->json('GET', '/api/journals/' . $journal->id);

    $response->assertStatus(200);
    $response->assertJsonStructure($singleJsonStructure);
});

it('restricts access to a journal', function () use ($singleJsonStructure): void {
    $user = User::factory()->create();
    $journal = Journal::factory()->create();

    Sanctum::actingAs($user);

    $response = $this->json('GET', '/api/journals/' . $journal->id);

    $response->assertStatus(404);
});
