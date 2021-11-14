<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(50),
            'host_name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(5)->addHour(2),
            'price' => rand(10000, 100000),
            'remaining_tickets' => rand(10, 200)
        ];
    }
}
