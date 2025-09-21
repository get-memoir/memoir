<?php

declare(strict_types=1);

use App\Models\JournalEntry;
use App\Models\JournalEntryMastodon;
use App\Models\User;

it('belongs to a user', function (): void {
    $user = User::factory()->create();
    $mastodonEntry = JournalEntryMastodon::factory()->create([
        'user_id' => $user->id,
    ]);

    expect($mastodonEntry->user()->exists())->toBeTrue();
    expect($mastodonEntry->user->id)->toBe($user->id);
});

it('belongs to a journal entry', function (): void {
    $journalEntry = JournalEntry::factory()->create();
    $mastodonEntry = JournalEntryMastodon::factory()->create([
        'journal_entry_id' => $journalEntry->id,
    ]);

    expect($mastodonEntry->journalEntry()->exists())->toBeTrue();
    expect($mastodonEntry->journalEntry->id)->toBe($journalEntry->id);
});
