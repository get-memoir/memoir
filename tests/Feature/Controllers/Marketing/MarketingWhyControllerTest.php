<?php

declare(strict_types=1);

it('returns ok response for why index', function (): void {
    $response = $this->get('/why')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});
