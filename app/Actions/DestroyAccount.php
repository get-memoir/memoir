<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\EmailType;
use App\Jobs\SendEmail;
use App\Models\User;

final class DestroyAccount
{
    public function __construct(
        public User $user,
    ) {}

    /**
     * Destroy an account.
     */
    public function execute(): void
    {
        $this->sendEmailToUser();
        $this->delete();
    }

    private function delete(): void
    {
        $this->user->delete();
    }

    private function sendEmailToUser(): void
    {
        SendEmail::dispatch(
            emailType: EmailType::ACCOUNT_DESTROYED,
            user: $this->user,
            parameters: [],
        )->onQueue('high');
    }
}
