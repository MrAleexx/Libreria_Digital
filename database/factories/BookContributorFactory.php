<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookContributorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'book_id' => \App\Models\Book::factory(),
            'contributor_type' => 'author',
            'full_name' => fake()->name(),
            'sequence_number' => 1,
        ];
    }

    public function author()
    {
        return $this->state(fn(array $attributes) => [
            'contributor_type' => 'author',
        ]);
    }

    public function editor()
    {
        return $this->state(fn(array $attributes) => [
            'contributor_type' => 'editor',
        ]);
    }
}
