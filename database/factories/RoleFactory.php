<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
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
            'name' => $this->faker->jobTitle(),

            // menghubungkan relasi company
            'company_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
