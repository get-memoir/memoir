<?php

declare(strict_types=1);

use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;

it('updates user last activity date', function (): void {
    $user = User::factory()->create([
        'last_activity_at' => null,
    ]);

    UpdateUserLastActivityDate::dispatch($user);

    $user->refresh();

    expect($user->last_activity_at)->not->toBeNull();
    expect($user->last_activity_at->timestamp)
        ->toEqualWithDelta(now()->timestamp, 1);
});
