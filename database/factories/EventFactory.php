<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Event;
use App\Models\Category;
use App\Models\Organizer;
use App\Traits\ImageUpload;
use function Laravel\Prompts\text;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    use ImageUpload;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category_id = Category::inRandomOrder()->pluck('id')->first();
        $organizer_id = Organizer::inRandomOrder()->pluck('id')->first();
        return [
            'organizer_id' => $organizer_id,
            'category_id' => $category_id,
            'title' => fake()->sentence(7, false),
            'description' => fake()->text(1000),
            'capacity' => fake()->numberBetween(200, 2000),
            'date' => fake()->dateTimeBetween('now', '+1 week'),
            'location' => fake()->city(),
        ];
    }

    public function withImage()
    {
        return $this->afterCreating(function (Event $event) {
            $imageUrl = $this->faker->imageUrl(360, 360, 'event');
            $this->storeFakeImg($imageUrl, $event);
        });
    }
}
