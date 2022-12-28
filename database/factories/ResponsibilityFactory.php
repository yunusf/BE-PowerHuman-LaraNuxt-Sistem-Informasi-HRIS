<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Responsibility>
 */
class ResponsibilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // membuat data faker
            'name' => $this->faker->bs(), // bs() => bisa dibilang jobdesk

            // menghubungkan relasi role
            'role_id' => $this->faker->numberBetween(1, 50),
        ];
    }
}
