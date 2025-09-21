<?php

declare(strict_types=1);

use App\Models\Journal;
use App\Models\JournalEntry;

it('belongs to a user', function (): void {
    $journal = Journal::factory()->create();

    expect($journal->user()->exists())->toBeTrue();
});

it('has many entries', function (): void {
    $journal = Journal::factory()->create();
    JournalEntry::factory()->count(2)->create([
        'journal_id' => $journal->id,
    ]);

    expect($journal->entries()->exists())->toBeTrue();
});

it('gets the avatar', function (): void {
    $journal = Journal::factory()->create();

    expect($journal->avatar())->toBeString();
});
