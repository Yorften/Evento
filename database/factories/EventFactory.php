<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

use function Laravel\Prompts\text;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category_id = Category::inRandomOrder()->pluck('id')->first();
        $user_id = User::role('organizer')->inRandomOrder()->pluck('id')->first();
        return [
            'user_id' => $user_id,
            'category_id' => $category_id,
            'title' => fake()->title(),
            'description' => fake()->text(1000),
            'capacity' => fake()->numberBetween(200,2000),
            'date' => fake()->dateTimeBetween('now', '+1 week'),
            'location' => fake()->city(),
        ];
    }
}
