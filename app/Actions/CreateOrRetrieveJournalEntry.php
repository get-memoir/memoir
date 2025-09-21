<?php

declare(strict_types=1);

namespace App\Actions;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Journal;
use App\Models\JournalEntry;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Create or retrieve an entry for a journal.
 * If the entry already exists, it will be retrieved.
 */
final class CreateOrRetrieveJournalEntry
{
    private JournalEntry $entry;

    private Carbon $date;

    public function __construct(
        private readonly User $user,
        private readonly Journal $journal,
        private readonly int $day,
        private readonly int $month,
        private readonly int $year,
    ) {}

    public function execute(): JournalEntry
    {
        $this->validate();
        $this->create();
        $this->updateUserLastActivityDate();

        return $this->entry;
    }

    private function validate(): void
    {
        if ($this->journal->user_id !== $this->user->id) {
            throw new ModelNotFoundException('Journal not found');
        }

        // check if the date is a real date
        if (! checkdate($this->month, $this->day, $this->year)) {
            throw new Exception('Invalid date');
        }

        $this->date = Carbon::create($this->year, $this->month, $this->day);
    }

    private function create(): void
    {
        $existingEntry = JournalEntry::where('journal_id', $this->journal->id)
            ->where('day', $this->day)
            ->where('month', $this->month)
            ->where('year', $this->year)
            ->first();

        if ($existingEntry) {
            $this->entry = $existingEntry;
        } else {
            $this->entry = JournalEntry::create([
                'journal_id' => $this->journal->id,
                'day' => $this->day,
                'month' => $this->month,
                'year' => $this->year,
            ]);

            $this->logUserAction();
        }
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'entry_creation',
            description: 'Created the entry on ' . $this->date->format('l F jS, Y') . ' for the journal called ' . $this->journal->name,
        )->onQueue('low');
    }
}
