<?php
// database/factories/BookFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class BookFactory extends Factory
{
    protected $model = \App\Models\Book::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(3),
            'isbn' => $this->faker->unique()->isbn13(),
            'isbn13' => $this->faker->isbn13(),
            'deposito_legal' => 'DL-' . $this->faker->randomNumber(5),
            'publisher' => $this->faker->company(),
            'publisher_address' => $this->faker->address(),
            'publisher_email' => $this->faker->companyEmail(),
            'publisher_city' => $this->faker->city(),
            'language' => 'es',
            'pages' => $this->faker->numberBetween(100, 500),
            'publication' => $this->faker->date(),
            'edition' => $this->faker->randomElement(['1ra', '2da', '3ra']) . ' Edición',
            'file_format' => 'PDF',
            'file_size' => $this->faker->randomElement(['1.2 MB', '2.5 MB', '5.0 MB']),
            'price' => $this->faker->randomFloat(2, 10, 50),
            'reading_age' => $this->faker->randomElement(['12+', '16+', '18+']),
            'publication_url' => $this->faker->url(),
            'image' => UploadedFile::fake()->image('book-cover.jpg'),
            'pdf_file' => null,
            'is_new' => $this->faker->boolean(30),
            'active' => true,
            'downloadable' => true,
            'pre_order' => false,
            'published_at' => $this->faker->dateTime(),
        ];
    }
}
