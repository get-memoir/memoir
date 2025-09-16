<?php

declare(strict_types=1);

it('shows the why index page', function (): void {
    $response = $this->get('/why')
        ->assertOk();

    $response->assertViewHasAll([
        'marketingPage',
    ]);
});
