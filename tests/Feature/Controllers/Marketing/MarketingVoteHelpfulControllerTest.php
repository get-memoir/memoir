<?php

declare(strict_types=1);

use App\Models\MarketingPage;
use App\Models\User;

it('marks a page as helpful', function (): void {
    $user = User::factory()->create();
    $page = MarketingPage::factory()->create();

    $response = $this->actingAs($user)
        ->from('/some/page')
        ->post('/vote/' . $page->id . '/helpful');

    $response->assertRedirect('/some/page');
    $response->assertSessionHas('hasVoted', true);

    $this->assertDatabaseHas('marketing_page_user', [
        'user_id' => $user->id,
        'marketing_page_id' => $page->id,
        'helpful' => true,
    ]);

    $this->assertDatabaseHas('marketing_pages', [
        'id' => $page->id,
        'marked_helpful' => $page->marked_helpful + 1,
    ]);
});

it('unauthenticated user cannot mark page as helpful', function (): void {
    $page = MarketingPage::factory()->create();

    $response = $this->post('/vote/' . $page->id . '/helpful');

    $response->assertRedirect('/login');

    $this->assertDatabaseMissing('marketing_page_user', [
        'marketing_page_id' => $page->id,
    ]);
});
