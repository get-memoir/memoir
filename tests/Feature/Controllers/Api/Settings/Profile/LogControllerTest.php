<?php

declare(strict_types=1);

use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Sanctum\Sanctum;

$logJsonStructure = [
    'data' => [
        'type',
        'id',
        'attributes' => [
            'action',
            'description',
            'created_at',
            'updated_at',
        ],
        'links' => [
            'self',
        ],
    ],
];

$logsCollectionStructure = [
    'data' => [
        '*' => [
            'type',
            'id',
            'attributes' => [

                'action',
                'description',
                'created_at',
                'updated_at',
            ],
            'links' => [
                'self',
            ],
        ],
    ],
    'links' => [
        'first',
        'last',
        'prev',
        'next',
    ],
    'meta' => [
        'current_page',
        'from',
        'last_page',
        'path',
        'per_page',
        'to',
        'total',
    ],
];

it('can get paginated logs', function () use ($logsCollectionStructure): void {
    Carbon::setTestNow('2025-01-15 10:00:00');
    $user = User::factory()->create();

    Log::factory()->count(15)->create([
        'user_id' => $user->id,
    ]);

    Sanctum::actingAs($user);

    $response = $this->json('GET', '/api/settings/logs');

    $response->assertStatus(200);
    $response->assertJsonStructure($logsCollectionStructure);

    $response->assertJson([
        'meta' => [
            'current_page' => 1,
            'per_page' => 10,
            'total' => 15,
        ],
    ]);
});

it('can show a specific log', function () use ($logJsonStructure): void {
    Carbon::setTestNow('2025-01-15 10:00:00');
    $user = User::factory()->create();
    $log = Log::factory()->create([
        'user_id' => $user->id,
        'action' => 'user.login',
        'description' => 'User logged in successfully',
    ]);

    Sanctum::actingAs($user);

    $response = $this->json('GET', "/api/settings/logs/{$log->id}");

    $response->assertStatus(200);
    $response->assertJsonStructure($logJsonStructure);

    $response->assertJson([
        'data' => [
            'type' => 'log',
            'id' => (string) $log->id,
            'attributes' => [
                'action' => 'user.login',
                'description' => 'User logged in successfully',
                'created_at' => 1736935200,
                'updated_at' => 1736935200,
            ],
        ],
    ]);
});

it('returns 403 when trying to access another user log', function (): void {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $log = Log::factory()->create([
        'user_id' => $user2->id,
    ]);

    Sanctum::actingAs($user1);

    $response = $this->json('GET', "/api/settings/logs/{$log->id}");

    $response->assertForbidden();
    $response->assertJson([
        'message' => 'Unauthorized action.',
    ]);
});

it('returns 401 when not authenticated', function (): void {
    $response = $this->json('GET', '/api/settings/logs');
    $response->assertUnauthorized();

    $log = Log::factory()->create();
    $response = $this->json('GET', "/api/settings/logs/{$log->id}");
    $response->assertUnauthorized();
});
