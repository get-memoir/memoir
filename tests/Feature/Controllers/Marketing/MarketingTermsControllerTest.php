<?php

declare(strict_types=1);

use App\Models\MarketingPage;

it('shows the terms of use page', function (): void {
    MarketingPage::factory()->create();

    $response = $this->get('/terms');

    $response->assertOk();
    $response->assertViewIs('marketing.terms');
});
