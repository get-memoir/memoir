<?php

declare(strict_types=1);

namespace App\Actions;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\MarketingTestimonial;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final readonly class DestroyMarketingTestimonial
{
    public function __construct(
        private User $user,
        private MarketingTestimonial $testimonial,
    ) {}

    public function execute(): void
    {
        $this->validate();
        $this->destroy();
        $this->updateUserLastActivityDate();
        $this->logUserAction();
    }

    private function validate(): void
    {
        if ($this->user->id !== $this->testimonial->user_id) {
            throw new ModelNotFoundException();
        }
    }

    private function destroy(): void
    {
        $this->testimonial->delete();
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'marketing_testimonial_deletion',
            description: 'Deleted a marketing testimonial',
        )->onQueue('low');
    }
}
