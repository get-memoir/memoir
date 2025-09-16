<?php

declare(strict_types=1);

it('returns ok response for company index', function (): void {
    $response = $this->get('/company')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});
