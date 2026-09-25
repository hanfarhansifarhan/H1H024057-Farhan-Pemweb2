<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'program_studi_id' => 1,
            'nim' => fake()->unique()->numerify('H1A########'),
            'nama' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'angkatan' => fake()->numberBetween(2021, 2025),
            'ipk' => fake()->randomFloat(2, 2.50, 4.00),
            'aktif' => fake()->boolean(85),
        ];
    }
}