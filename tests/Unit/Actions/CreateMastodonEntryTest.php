<?php

declare(strict_types=1);

use App\Models\User;
use App\Actions\CreateMastodonEntry;
use App\Models\MastodonEntry;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

it('creates a mastodon entry', function (): void {
    Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

    $mastodonEntry = (new CreateMastodonEntry(
        mastodonUsername: 'testuser',
        content: 'Hello, world!',
        url: 'https://example.com',
        publishedAt: now(),
    ))->execute();

    expect($mastodonEntry)->toBeInstanceOf(MastodonEntry::class);

    $this->assertDatabaseHas('mastodon_entries', [
        'id' => $mastodonEntry->id,
        'mastodon_username' => 'testuser',
        'content' => 'Hello, world!',
        'url' => 'https://example.com',
        'published_at' => '2025-03-17 10:00:00',
    ]);
});
