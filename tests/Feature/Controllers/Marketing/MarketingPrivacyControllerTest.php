<?php

declare(strict_types=1);

it('shows the privacy index page', function (): void {
    $response = $this->get('/privacy')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});
