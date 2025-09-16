<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\MarketingPage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MarketingPage>
 */
final class MarketingPageFactory extends Factory
{
    protected $model = MarketingPage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'url' => fake()->url(),
            'marked_helpful' => fake()->numberBetween(1, 100),
            'marked_not_helpful' => fake()->numberBetween(1, 100),
        ];
    }
}
