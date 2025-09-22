<?php

declare(strict_types=1);

use App\Actions\UpdateJournalName;
use App\Jobs\LogUserAction;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Queue;
use Illuminate\Validation\ValidationException;

it('updates the journal name', function (): void {
    Queue::fake();

    $user = User::factory()->create();
    $journal = Journal::factory()->create([
        'user_id' => $user->id,
        'name' => 'Old Journal Name',
    ]);

    $journal = (new UpdateJournalName(
        user: $user,
        journal: $journal,
        name: 'New Journal Name',
    ))->execute();

    expect($journal)->toBeInstanceOf(Journal::class);

    $this->assertDatabaseHas('journals', [
        'id' => $journal->id,
        'user_id' => $user->id,
        'name' => 'New Journal Name',
    ]);

    expect($journal->refresh()->name)->toBe('New Journal Name');

    Queue::assertPushedOn(
        queue: 'low',
        job: LogUserAction::class,
        callback: function (LogUserAction $job) use ($user): bool {
            return $job->action === 'update_journal_name'
                && $job->user->id === $user->id
                && str_contains($job->description, 'Updated the journal name from Old Journal Name to New Journal Name');
        },
    );
});

it('throws validation exception for name with special characters', function (): void {
    $user = User::factory()->create();
    $journal = Journal::factory()->create([
        'user_id' => $user->id,
        'name' => 'Valid Name',
    ]);

    expect(fn() => (new UpdateJournalName(
        user: $user,
        journal: $journal,
        name: 'Invalid@Name!',
    ))->execute())->toThrow(ValidationException::class, 'Journal name can only contain letters, numbers, spaces, hyphens and underscores');
});

it('throws validation exception for name with symbols', function (): void {
    $user = User::factory()->create();
    $journal = Journal::factory()->create([
        'user_id' => $user->id,
        'name' => 'Valid Name',
    ]);

    expect(fn() => (new UpdateJournalName(
        user: $user,
        journal: $journal,
        name: 'Name with $ symbol',
    ))->execute())->toThrow(ValidationException::class);
});

it('allows valid names with letters numbers spaces hyphens and underscores', function (string $validName): void {
    Queue::fake();

    $user = User::factory()->create();
    $journal = Journal::factory()->create([
        'user_id' => $user->id,
        'name' => 'Old Name',
    ]);

    $updatedUser = (new UpdateJournalName(
        user: $user,
        journal: $journal,
        name: $validName,
    ))->execute();

    expect($updatedUser)->toBeInstanceOf(User::class);
    expect($journal->refresh()->name)->toBe($validName);
})->with([
    'Simple Name',
    'Name-with-hyphens',
    'Name_with_underscores',
    'Name123',
    'Name with spaces',
    'Mixed-Name_123 Test',
]);

it('throws model not found exception when journal does not belong to user', function (): void {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $journal = Journal::factory()->create([
        'user_id' => $user2->id,
        'name' => 'Journal Name',
    ]);

    expect(fn() => (new UpdateJournalName(
        user: $user1,
        journal: $journal,
        name: 'New Name',
    ))->execute())->toThrow(ModelNotFoundException::class, 'Journal not found');
});
