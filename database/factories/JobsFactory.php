<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jobs>
 */
class JobsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
'title' => $this->faker->title(),
'client_id' => $this->faker->numberBetween(1,10),
'description' =>$this->faker->name(),
'price' => $this->faker->numberBetween(1000,100000),
'tags' => $this->faker->randomElement(['php', 'html', 'python'])
        ];
    }
}
