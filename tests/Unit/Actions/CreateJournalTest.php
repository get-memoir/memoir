<?php

declare(strict_types=1);

use App\Actions\CreateJournal;
use App\Models\User;
use Carbon\Carbon;
use App\Jobs\LogUserAction;
use App\Models\Journal;
use Illuminate\Support\Facades\Queue;
use Illuminate\Validation\ValidationException;

it('creates a journal', function (): void {
    Queue::fake();
    Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

    $user = User::factory()->create();

    $journal = (new CreateJournal(
        user: $user,
        name: 'Dunder Mifflin',
    ))->execute();

    $this->assertDatabaseHas('journals', [
        'id' => $journal->id,
        'name' => 'Dunder Mifflin',
        'slug' => $journal->id . '-dunder-mifflin',
    ]);

    expect($journal)->toBeInstanceOf(Journal::class);

    Queue::assertPushedOn(
        queue: 'low',
        job: LogUserAction::class,
        callback: function (LogUserAction $job) use ($user): bool {
            return $job->action === 'journal_creation' && $job->user->id === $user->id;
        },
    );
});

it('throws an exception if journal name contains special characters', function (): void {
    $this->expectException(ValidationException::class);

    $user = User::factory()->create();

    (new CreateJournal(
        user: $user,
        name: 'Dunder@ / Mifflin!',
    ))->execute();
});
