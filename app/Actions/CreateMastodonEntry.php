<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\MastodonEntry;
use App\Models\User;
use Carbon\Carbon;
use MagicLink\Actions\LoginAction;
use MagicLink\MagicLink;

final class CreateMastodonEntry
{
    private MastodonEntry $mastodonEntry;

    public function __construct(
        private readonly string $mastodonUsername,
        private readonly string $content,
        private readonly string $url,
        private readonly Carbon $publishedAt,
    ) {}

    public function execute(): MastodonEntry
    {
        $this->create();

        return $this->mastodonEntry;
    }

    private function create(): void
    {
        $this->mastodonEntry = MastodonEntry::create([
            'mastodon_username' => $this->mastodonUsername,
            'content' => $this->content,
            'url' => $this->url,
            'published_at' => $this->publishedAt,
        ]);
    }
}
