<?php

declare(strict_types=1);

use App\Models\MarketingPage;
use App\Models\User;

it('destroys a marketing vote', function (): void {
    $user = User::factory()->create();
    $page = MarketingPage::factory()->create([
        'marked_helpful' => 1,
    ]);

    $user->marketingPages()->attach($page->id, [
        'helpful' => true,
    ]);

    $response = $this->actingAs($user)
        ->from('/some/page')
        ->delete('/vote/' . $page->id);

    $response->assertRedirect('/some/page');

    $this->assertDatabaseMissing('marketing_page_user', [
        'user_id' => $user->id,
        'marketing_page_id' => $page->id,
    ]);

    expect($page->fresh()->marked_helpful)->toBe(0);
});

it('cant destroy vote for unauthenticated user', function (): void {
    $page = MarketingPage::factory()->create();

    $response = $this->delete('/vote/' . $page->id);

    $response->assertRedirect('/login');

    $this->assertDatabaseMissing('marketing_page_user', [
        'marketing_page_id' => $page->id,
    ]);
});
