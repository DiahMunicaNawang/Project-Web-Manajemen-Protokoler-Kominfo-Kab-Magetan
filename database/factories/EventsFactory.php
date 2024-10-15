<?php

namespace Database\Factories;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Events>
 */
class EventsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'location' => $this->faker->address,
            'dinas' => $this->faker->company,
            'file_pdf' => $this->faker->word . '.pdf',
            'start_date' => $this->faker->dateTimeBetween('now', '+7 weeks')->format('Y-m-d H:i:s'),
            'end_date' => $this->faker->dateTimeBetween('now', '+7 weeks')->format('Y-m-d H:i:s'),
        ];
    }
}
