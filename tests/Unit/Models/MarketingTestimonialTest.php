<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\MarketingTestimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class MarketingTestimonialTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_a_user(): void
    {
        $user = User::factory()->create();
        $testimony = MarketingTestimonial::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertTrue($testimony->user()->exists());
    }
}
