<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookContentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'book_id' => \App\Models\Book::factory(),
            'chapter_title' => fake()->sentence(3),
            'chapter_number' => fake()->numberBetween(1, 20),
            'page_start' => fake()->numberBetween(1, 100),
            'page_end' => fake()->numberBetween(101, 300),
            'description' => fake()->paragraph(),
            'sort_order' => fake()->numberBetween(1, 50),
            'level' => fake()->numberBetween(0, 3),
        ];
    }

    public function forBook($book)
    {
        return $this->state(fn(array $attributes) => [
            'book_id' => $book->id,
        ]);
    }

    public function mainChapter()
    {
        return $this->state(fn(array $attributes) => [
            'level' => 0,
            'chapter_number' => 1,
        ]);
    }

    public function subChapter()
    {
        return $this->state(fn(array $attributes) => [
            'level' => 1,
        ]);
    }
}
