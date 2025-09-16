<?php

declare(strict_types=1);

it('returns ok response for privacy index', function (): void {
    $response = $this->get('/privacy')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});
