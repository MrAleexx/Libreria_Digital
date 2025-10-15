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
            'edition' => fake()->randomElement(['1ra', '2da', '3ra', '4ta', '5ta']),
            'file_format' => fake()->randomElement(['PDF', 'EPUB', 'MOBI']),
            'file_size' => fake()->randomElement(['1.2 MB', '2.5 MB', '5.0 MB', '10.2 MB', '15.8 MB']),
            'reading_age' => fake()->randomElement(['0-3', '4-6', '7-9', '10-12', '13-15', '16-18', '18+', 'all']),
            'deposito_legal' => 'B ' . fake()->numerify('#####-####'),
            'restrictions' => fake()->optional(0.3)->sentence(), // 30% de probabilidad
            'notes' => fake()->optional(0.2)->paragraph(), // 20% de probabilidad
        ];
    }

    public function forBook($book)
    {
        return $this->state(fn(array $attributes) => [
            'book_id' => $book->id,
        ]);
    }

    public function withDetailedDescription()
    {
        return $this->state(fn(array $attributes) => [
            'description' => fake()->paragraphs(5, true),
        ]);
    }

    public function withRestrictions()
    {
        return $this->state(fn(array $attributes) => [
            'restrictions' => fake()->sentence(),
        ]);
    }

    public function withNotes()
    {
        return $this->state(fn(array $attributes) => [
            'notes' => fake()->paragraph(),
        ]);
    }

    public function firstEdition()
    {
        return $this->state(fn(array $attributes) => [
            'edition' => '1ra',
        ]);
    }

    public function latestEdition()
    {
        return $this->state(fn(array $attributes) => [
            'edition' => fake()->randomElement(['3ra', '4ta', '5ta']),
        ]);
    }

    public function largeFile()
    {
        return $this->state(fn(array $attributes) => [
            'file_size' => fake()->randomElement(['15.8 MB', '20.1 MB', '25.5 MB']),
        ]);
    }

    public function smallFile()
    {
        return $this->state(fn(array $attributes) => [
            'file_size' => fake()->randomElement(['500 KB', '1.2 MB', '2.0 MB']),
        ]);
    }

    public function forChildren()
    {
        return $this->state(fn(array $attributes) => [
            'reading_age' => fake()->randomElement(['0-3', '4-6', '7-9']),
        ]);
    }

    public function forYoungAdults()
    {
        return $this->state(fn(array $attributes) => [
            'reading_age' => fake()->randomElement(['13-15', '16-18']),
        ]);
    }

    public function forAdults()
    {
        return $this->state(fn(array $attributes) => [
            'reading_age' => '18+',
        ]);
    }

    public function forAllAges()
    {
        return $this->state(fn(array $attributes) => [
            'reading_age' => 'all',
        ]);
    }

    public function epubFormat()
    {
        return $this->state(fn(array $attributes) => [
            'file_format' => 'EPUB',
        ]);
    }

    public function mobiFormat()
    {
        return $this->state(fn(array $attributes) => [
            'file_format' => 'MOBI',
        ]);
    }

    public function pdfFormat()
    {
        return $this->state(fn(array $attributes) => [
            'file_format' => 'PDF',
        ]);
    }
}
