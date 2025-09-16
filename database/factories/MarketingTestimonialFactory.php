<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\MarketingTestimonialStatus;
use App\Models\MarketingTestimonial;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MarketingTestimonial>
 */
final class MarketingTestimonialFactory extends Factory
{
    protected $model = MarketingTestimonial::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'status' => fake()->randomElement(MarketingTestimonialStatus::cases())->value,
            'name_to_display' => fake()->name(),
            'url_to_point_to' => fake()->url(),
            'display_avatar' => fake()->boolean(),
            'testimony' => fake()->sentence(),
        ];
    }
}
