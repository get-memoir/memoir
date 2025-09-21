<?php

declare(strict_types=1);

use App\Models\Journal;
use App\Models\JournalEntry;

it('belongs to a journal', function (): void {
    $journal = Journal::factory()->create();
    $journalEntry = JournalEntry::factory()->create([
        'journal_id' => $journal->id,
    ]);

    expect($journalEntry->journal()->exists())->toBeTrue();
});

it('gets the date', function (): void {
    $journalEntry = JournalEntry::factory()->create([
        'day' => 1,
        'month' => 1,
        'year' => 2021,
    ]);

    expect($journalEntry->getDate())->toBe('Friday January 1st, 2021');
});
