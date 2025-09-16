<?php

declare(strict_types=1);

use App\Actions\DestroyAccount;
use App\Enums\EmailType;
use App\Jobs\SendEmail;
use App\Models\User;
use Illuminate\Support\Facades\Queue;

it('deletes an account and queues a confirmation email', function (): void {
    Queue::fake();

    $user = User::factory()->create();

    (new DestroyAccount(
        user: $user,
    ))->execute();

    $this->assertDatabaseMissing('users', [
        'id' => $user->id,
    ]);

    Queue::assertPushedOn(
        queue: 'high',
        job: SendEmail::class,
        callback: function (SendEmail $job) use ($user): bool {
            return $job->user->is($user)
                && $job->emailType === EmailType::ACCOUNT_DESTROYED
                && $job->parameters === [];
        },
    );
});
