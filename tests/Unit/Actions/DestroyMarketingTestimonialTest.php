<?php

declare(strict_types=1);

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\MarketingTestimonial;
use App\Models\User;
use App\Actions\DestroyMarketingTestimonial;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Queue;

it('destroys a marketing testimony', function (): void {
    Queue::fake();

    $user = User::factory()->create([
        'first_name' => 'Phoebe',
        'last_name' => 'Buffay',
    ]);
    $testimonial = MarketingTestimonial::factory()->create([
        'user_id' => $user->id,
        'name_to_display' => 'Phoebe Buffay',
        'testimony' => 'Smelly Cat, what are they feeding you?',
    ]);

    (new DestroyMarketingTestimonial(
        user: $user,
        testimonial: $testimonial,
    ))->execute();

    $this->assertDatabaseMissing('marketing_testimonials', [
        'id' => $testimonial->id,
    ]);

    Queue::assertPushedOn(
        queue: 'low',
        job: UpdateUserLastActivityDate::class,
        callback: function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        },
    );

    Queue::assertPushedOn(
        queue: 'low',
        job: LogUserAction::class,
        callback: function (LogUserAction $job) use ($user): bool {
            return $job->action === 'marketing_testimonial_deletion'
                && $job->user->id === $user->id
                && $job->description === 'Deleted a marketing testimonial';
        },
    );
});

it('fails if user is not in the same account', function (): void {
    $user = User::factory()->create([
        'first_name' => 'Joey',
        'last_name' => 'Tribbiani',
    ]);
    $testimonial = MarketingTestimonial::factory()->create();

    expect(fn() => (new DestroyMarketingTestimonial(
        user: $user,
        testimonial: $testimonial,
    ))->execute())->toThrow(ModelNotFoundException::class);
});
