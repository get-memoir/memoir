<?php

declare(strict_types=1);

use App\Models\MarketingPage;
use App\Models\User;

it('marks a page as unhelpful', function (): void {
    $user = User::factory()->create();
    $page = MarketingPage::factory()->create();

    $response = $this->actingAs($user)
        ->from('/some/page')
        ->post('/vote/' . $page->id . '/unhelpful');

    $response->assertRedirect('/some/page');
    $response->assertSessionHas('hasVoted', true);

    $this->assertDatabaseHas('marketing_page_user', [
        'user_id' => $user->id,
        'marketing_page_id' => $page->id,
        'helpful' => false,
    ]);

    $this->assertDatabaseHas('marketing_pages', [
        'id' => $page->id,
        'marked_not_helpful' => $page->marked_not_helpful + 1,
    ]);
});

it('cant mark page as unhelpful for unauthenticated user', function (): void {
    $page = MarketingPage::factory()->create();

    $response = $this->post('/vote/' . $page->id . '/unhelpful');

    $response->assertRedirect('/login');

    $this->assertDatabaseMissing('marketing_page_user', [
        'marketing_page_id' => $page->id,
    ]);
});
