<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\User;
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
        $feed = FeedsFacade::make($this->user->mastodon_username);

        $this->items = array(
            'title'     => $feed->get_title(),
            'permalink' => $feed->get_permalink(),
            'items'     => $feed->get_items(),
        );
    }

    private function createOrUpdateEntries(): void
    {
        dd($this->items);
    }
}
