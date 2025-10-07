<?php
// database/factories/BookContributorFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookContributorFactory extends Factory
{
    protected $model = \App\Models\BookContributor::class;

    public function definition(): array
    {
        return [
            'book_id' => \App\Models\Book::factory(),
            'contributor_type' => $this->faker->randomElement(['author', 'editor', 'translator', 'illustrator']),
            'full_name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'sequence_number' => $this->faker->numberBetween(1, 5),
            'biographical_note' => $this->faker->paragraph(2),
        ];
    }
}
