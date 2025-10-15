<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'isbn' => fake()->isbn13(),
            'publisher_id' => \App\Models\Publisher::factory(),
            'language_code' => 'es',
            'publication_year' => fake()->year(),
            'pages' => fake()->numberBetween(100, 500),
            'cover_image' => 'books/default-cover.jpg',
            'pdf_file' => 'books/pdfs/sample.pdf',
            'book_type' => fake()->randomElement(['digital', 'physical', 'both']),
            'access_level' => 'free',
            'copyright_status' => 'copyrighted',
            'license_type' => null,
            'is_active' => true,
            'downloadable' => true,
            'featured' => false,
            'is_featured_new' => false,
            'total_downloads' => 0,
            'total_views' => 0,
            'total_physical_copies' => 0,
            'available_physical_copies' => 0,
            'total_loans' => 0,
        ];
    }

    public function digital()
    {
        return $this->state(fn(array $attributes) => [
            'book_type' => 'digital',
        ]);
    }

    public function physical()
    {
        return $this->state(fn(array $attributes) => [
            'book_type' => 'physical',
            'total_physical_copies' => 5,
            'available_physical_copies' => 3,
        ]);
    }

    public function both()
    {
        return $this->state(fn(array $attributes) => [
            'book_type' => 'both',
            'total_physical_copies' => 3,
            'available_physical_copies' => 2,
        ]);
    }

    public function featured()
    {
        return $this->state(fn(array $attributes) => [
            'featured' => true,
        ]);
    }

    public function inactive()
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function premium()
    {
        return $this->state(fn(array $attributes) => [
            'access_level' => 'premium',
        ]);
    }
}
