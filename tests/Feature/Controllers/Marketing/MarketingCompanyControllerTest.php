<?php

declare(strict_types=1);

it('shows the company index page', function (): void {
    $response = $this->get('/company')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});
