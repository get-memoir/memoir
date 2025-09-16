<?php

declare(strict_types=1);

it('returns ok response for pricing index', function (): void {
    $response = $this->get('/pricing')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});
