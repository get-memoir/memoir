<?php

declare(strict_types=1);

use App\Models\Journal;
use App\Models\User;

it('updates a journal name', function (): void {
    $user = User::factory()->create();
    $journal = Journal::factory()->create([
        'user_id' => $user->id,
        'name' => 'Dunder Mifflin',
    ]);

    $this->actingAs($user);

    $page = visit('/journals/' . $journal->slug . '/settings');

    $page->type('journal_name', 'New Dunder Mifflin');
    $page->press('@update-journal-name-button');
    $page->assertSee('New Dunder Mifflin');
});
