<?php

declare(strict_types=1);

use App\Actions\CreateOrRetrieveJournalEntry;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Journal;
use App\Models\JournalEntry;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Queue;

it('creates an entry', function (): void {
    Queue::fake();

    $user = User::factory()->create();
    $journal = Journal::factory()->create([
        'user_id' => $user->id,
        'name' => 'Dunder Mifflin Journal',
    ]);

    $entry = (new CreateOrRetrieveJournalEntry(
        user: $user,
        journal: $journal,
        day: 1,
        month: 1,
        year: 2024,
    ))->execute();

    $this->assertDatabaseHas('journal_entries', [
        'id' => $entry->id,
        'journal_id' => $journal->id,
        'day' => 1,
        'month' => 1,
        'year' => 2024,
    ]);

    expect($entry)->toBeInstanceOf(JournalEntry::class);

    Queue::assertPushedOn(
        queue: 'low',
        job: UpdateUserLastActivityDate::class,
        callback: function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        },
    );

    Queue::assertPushedOn(
        queue: 'low',
        job: LogUserAction::class,
        callback: function (LogUserAction $job) use ($user): bool {
            return $job->action === 'entry_creation'
                && $job->user->id === $user->id
                && str_contains($job->description, 'Dunder Mifflin Journal');
        },
    );
});

it('retrieves an existing entry', function (): void {
    $user = User::factory()->create();
    $journal = Journal::factory()->create([
        'user_id' => $user->id,
    ]);
    $existingEntry = JournalEntry::factory()->create([
        'journal_id' => $journal->id,
        'day' => 1,
        'month' => 1,
        'year' => 2024,
    ]);

    $entry = (new CreateOrRetrieveJournalEntry(
        user: $user,
        journal: $journal,
        day: 1,
        month: 1,
        year: 2024,
    ))->execute();

    expect($entry->id)->toBe($existingEntry->id);
});

it('fails if journal doesnt belong to user', function (): void {
    $user = User::factory()->create();
    $journal = Journal::factory()->create();

    expect(fn() => (new CreateOrRetrieveJournalEntry(
        user: $user,
        journal: $journal,
        day: 1,
        month: 1,
        year: 2024,
    ))->execute())->toThrow(ModelNotFoundException::class);
});

it('fails if date is invalid', function (): void {
    $user = User::factory()->create();
    $journal = Journal::factory()->create([
        'user_id' => $user->id,
    ]);

    expect(fn() => (new CreateOrRetrieveJournalEntry(
        user: $user,
        journal: $journal,
        day: 31,
        month: 2,
        year: 2024,
    ))->execute())->toThrow(Exception::class, 'Invalid date');
});
