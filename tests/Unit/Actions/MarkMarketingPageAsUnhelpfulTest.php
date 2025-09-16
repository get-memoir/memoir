<?php

declare(strict_types=1);

use App\Models\MarketingPage;
use App\Models\User;
use App\Actions\MarkMarketingPageAsUnhelpful;

it('should mark marketing page as unhelpful for user', function (): void {
    $user = User::factory()->create();
    $marketingPage = MarketingPage::factory()->create();

    $service = new MarkMarketingPageAsUnhelpful(
        user: $user,
        marketingPage: $marketingPage,
    );

    $service->execute();

    $this->assertDatabaseHas('marketing_page_user', [
        'user_id' => $user->id,
        'marketing_page_id' => $marketingPage->id,
        'helpful' => false,
    ]);
});
