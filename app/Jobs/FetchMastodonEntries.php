<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Actions\CreateMastodonEntry;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use willvincent\Feeds\Facades\FeedsFacade;

final class FetchMastodonEntries implements ShouldQueue
{
    use Queueable;

    private array $items;

    public function __construct(
        public User $user,
    ) {}

    /**
     * Fetch the mastodon entries for the user.
     */
    public function handle(): void
    {
        $this->validate();
        $this->fetchFeed();
        $this->createOrUpdateEntries();
    }

    private function validate(): void
    {
        if (!$this->user->mastodon_username) {
            throw new Exception('Mastodon username is required');
        }
    }

    private function fetchFeed(): void
    {
        $feed = FeedsFacade::make([$this->user->mastodon_username], 20, true);

        $this->items = [
            'title'     => $feed->get_title(),
            'permalink' => $feed->get_permalink(),
            'items'     => $feed->get_items(),
        ];
    }

    private function createOrUpdateEntries(): void
    {
        foreach ($this->items['items'] as $item) {
            $date = Carbon::parse($item->get_date());

            new CreateMastodonEntry(
                mastodonUsername: $this->user->mastodon_username,
                content: $item->get_content(),
                url: $item->get_permalink(),
                publishedAt: $date,
            )->execute();
        }
    }
}
