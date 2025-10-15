<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookDetailFactory extends Factory
{
    public function definition(): array
    {
        return [
            'book_id' => \App\Models\Book::factory(),
            'description' => fake()->paragraphs(3, true),
            'edition' => fake()->randomElement(['1ra', '2da', '3ra']),
            'file_format' => 'PDF',
            'file_size' => fake()->randomElement(['2.5 MB', '5.0 MB', '10.2 MB']),
            'reading_age' => fake()->randomElement(['12+', '16+', '18+']),
            'deposito_legal' => 'DL-' . fake()->numerify('#####'),
            'restrictions' => null,
            'notes' => null,
        ];
    }
}
