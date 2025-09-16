<?php

declare(strict_types=1);

it('shows the pricing index page', function (): void {
    $response = $this->get('/pricing')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});
