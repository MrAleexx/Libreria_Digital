<?php
// database/factories/BookFactory.php

namespace Database\Factories;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        // Obtener un código de lenguaje existente
        $existingLanguage = Language::inRandomOrder()->first() ??
            Language::factory()->create(['code' => 'es']);

        return [
            'title' => fake()->sentence(3),
            'isbn' => fake()->isbn13(),
            'publisher_id' => \App\Models\Publisher::factory(),
            'language_code' => $existingLanguage->code, // Usar lenguaje existente
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
            'total_physical_copies' => 0,
            'available_physical_copies' => 0,
        ]);
    }

    public function physical()
    {
        return $this->state(fn(array $attributes) => [
            'book_type' => 'physical',
            'total_physical_copies' => 5,
            'available_physical_copies' => 3,
            'pdf_file' => null, // Los libros físicos pueden no tener PDF
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

    public function institutional()
    {
        return $this->state(fn(array $attributes) => [
            'access_level' => 'institutional',
        ]);
    }

    public function publicDomain()
    {
        return $this->state(fn(array $attributes) => [
            'copyright_status' => 'public_domain',
            'license_type' => null,
        ]);
    }

    public function creativeCommons()
    {
        return $this->state(fn(array $attributes) => [
            'copyright_status' => 'creative_commons',
            'license_type' => 'CC BY-NC-SA 4.0',
        ]);
    }

    public function withDownloads($count = 10)
    {
        return $this->state(fn(array $attributes) => [
            'total_downloads' => $count,
        ]);
    }

    public function withViews($count = 50)
    {
        return $this->state(fn(array $attributes) => [
            'total_views' => $count,
        ]);
    }

    public function notDownloadable()
    {
        return $this->state(fn(array $attributes) => [
            'downloadable' => false,
        ]);
    }
}
