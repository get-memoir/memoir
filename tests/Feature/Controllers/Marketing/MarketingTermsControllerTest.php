<?php

declare(strict_types=1);

use App\Models\MarketingPage;

it('returns ok response for terms index', function (): void {
    MarketingPage::factory()->create();

    $response = $this->get('/terms');

    $response->assertOk();
    $response->assertViewIs('marketing.terms');
});
