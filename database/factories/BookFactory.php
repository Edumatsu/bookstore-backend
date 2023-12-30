<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Titulo' => fake()->sentence(4),
            'Editora' => fake()->sentence(2),
            'Edicao' => (int) fake()->numerify("###"),
            'AnoPublicacao' => fake()->year(),
            'Valor' => (float) fake()->numerify(),
        ];
    }
}
