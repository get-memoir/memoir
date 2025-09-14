<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Journal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Journal>
 */
final class JournalFactory extends Factory
{
    protected $model = Journal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->word(),
            'slug' => null,
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Journal $journal): void {
            if ($journal->slug === null) {
                $journal->slug = $journal->id . '-' . \Illuminate\Support\Str::slug($journal->name);
                $journal->save();
            }
        });
    }
}
