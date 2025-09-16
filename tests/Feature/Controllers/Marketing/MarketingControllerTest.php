<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Cache;

it('shows the homepage of marketing site', function (): void {
    $mockPRs = [
        [
            'number' => 123,
            'title' => 'Test PR Title',
            'merged_at' => '2024-03-20',
            'body' => 'Test PR Description',
            'url' => 'https://github.com/test/123',
        ],
    ];

    Cache::partialMock()
        ->shouldReceive('remember')
        ->withArgs(function ($key, $ttl, $callback) {
            return $key === 'github_pull_requests';
        })
        ->once()
        ->andReturn($mockPRs);

    Cache::partialMock()
        ->shouldReceive('remember')
        ->withArgs(function ($key, $ttl, $callback) {
            return $key === 'github_stars';
        })
        ->once()
        ->andReturn(1234);

    $response = $this->get('/')
        ->assertOk();

    $response->assertViewHasAll([
        'pullRequests' => $mockPRs,
        'stars' => 1234,
        'accountNumbers',
        'marketingPage',
    ]);
});
