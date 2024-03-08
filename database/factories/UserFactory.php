<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Client;
use App\Models\Organizer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    // Define a state to assign a role
    public function withRole($role)
    {
        return $this->afterCreating(function (User $user) use ($role) {
            $user->assignRole($role);
            if ($role == 'client') {
                Client::create([
                    'user_id' => $user->id,
                    'phone' => fake()->phoneNumber(),
                    'country' => fake()->country(),
                    'city' => fake()->city(),
                ]);
            } else {
                Organizer::create([
                    'user_id' => $user->id,
                    'phone' => fake()->phoneNumber(),
                    'company' => fake()->company(),
                    'website' => fake()->domainName(),
                    'type' => fake()->randomElement(['company', 'nonprofit']),
                    'company_email' => fake()->companyEmail(),
                ]);
            }
        });
    }
}
