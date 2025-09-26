<?php

declare(strict_types=1);

namespace App\Actions;

use App\Jobs\LogUserAction;
use App\Models\User;
use App\Models\Journal;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

final class UpdateJournalName
{
    private string $formerName;

    public function __construct(
        public User $user,
        public Journal $journal,
        public string $name,
    ) {}

    /**
     * Update the journal name.
     */
    public function execute(): Journal
    {
        $this->validate();
        $this->update();
        $this->generateSlug();
        $this->log();

        return $this->journal;
    }

    private function validate(): void
    {
        // make sure the journal name doesn't contain any special characters
        if (in_array(preg_match('/^[a-zA-Z0-9\s\-_]+$/', $this->name), [0, false], true)) {
            throw ValidationException::withMessages([
                'journal_name' => 'Journal name can only contain letters, numbers, spaces, hyphens and underscores',
            ]);
        }

        if ($this->journal->user_id !== $this->user->id) {
            throw new ModelNotFoundException('Journal not found');
        }
    }

    private function update(): void
    {
        $this->formerName = $this->journal->name;

        $this->journal->update([
            'name' => $this->name,
        ]);
    }

    private function generateSlug(): void
    {
        $slug = $this->journal->id . '-' . Str::of($this->name)->slug('-');

        $this->journal->slug = $slug;
        $this->journal->save();
    }

    private function log(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'update_journal_name',
            description: 'Updated the journal name from ' . $this->formerName . ' to ' . $this->name,
        )->onQueue('low');
    }
}
