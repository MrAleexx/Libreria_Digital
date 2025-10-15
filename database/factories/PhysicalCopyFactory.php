<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PhysicalCopyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'book_id' => \App\Models\Book::factory(),
            'barcode' => 'BC' . fake()->unique()->numerify('########'),
            'copy_number' => 1,
            'status' => 'available',
            'location' => fake()->randomElement(['Estante A-1', 'Estante B-2', 'Estante C-3']),
            'notes' => null,
        ];
    }

    public function available()
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'available',
        ]);
    }

    public function loaned()
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'loaned',
        ]);
    }

    public function reserved()
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'reserved',
        ]);
    }
}
