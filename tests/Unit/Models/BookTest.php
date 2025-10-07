<?php
// tests/Unit/Models/BookTest.php

namespace Tests\Unit\Models;

use App\Models\Book;
use App\Models\BookContributor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_a_book()
    {
        $book = Book::factory()->create([
            'title' => 'Libro de Prueba',
            'isbn' => '1234567890123'
        ]);

        $this->assertInstanceOf(Book::class, $book);
        $this->assertEquals('Libro de Prueba', $book->title);
        $this->assertEquals('1234567890123', $book->isbn);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_has_contributors_relationship()
    {
        $book = Book::factory()->create();
        BookContributor::factory()->count(3)->create(['book_id' => $book->id]);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $book->contributors);
        $this->assertCount(3, $book->contributors);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_returns_all_authors_correctly()
    {
        $book = Book::factory()->create();

        BookContributor::factory()->create([
            'book_id' => $book->id,
            'contributor_type' => 'author',
            'full_name' => 'Autor Uno',
            'sequence_number' => 1
        ]);

        BookContributor::factory()->create([
            'book_id' => $book->id,
            'contributor_type' => 'author',
            'full_name' => 'Autor Dos',
            'sequence_number' => 2
        ]);

        $this->assertEquals('Autor Uno, Autor Dos', $book->all_authors);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_returns_main_author_correctly()
    {
        $book = Book::factory()->create();

        BookContributor::factory()->create([
            'book_id' => $book->id,
            'contributor_type' => 'author',
            'full_name' => 'Autor Principal',
            'sequence_number' => 1
        ]);

        $this->assertEquals('Autor Principal', $book->main_author);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_returns_editors_correctly()
    {
        $book = Book::factory()->create();

        BookContributor::factory()->create([
            'book_id' => $book->id,
            'contributor_type' => 'editor',
            'full_name' => 'Editor Uno'
        ]);

        BookContributor::factory()->create([
            'book_id' => $book->id,
            'contributor_type' => 'editor',
            'full_name' => 'Editor Dos'
        ]);

        $this->assertEquals('Editor Uno, Editor Dos', $book->editors);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_add_author_using_helper_method()
    {
        $book = Book::factory()->create();

        $contributor = $book->addAuthor('Nuevo Autor', 1);

        $this->assertInstanceOf(BookContributor::class, $contributor);
        $this->assertEquals('Nuevo Autor', $contributor->full_name);
        $this->assertEquals('author', $contributor->contributor_type);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_get_contributors_by_type()
    {
        $book = Book::factory()->create();

        BookContributor::factory()->create([
            'book_id' => $book->id,
            'contributor_type' => 'author',
            'full_name' => 'Autor Test'
        ]);

        BookContributor::factory()->create([
            'book_id' => $book->id,
            'contributor_type' => 'editor',
            'full_name' => 'Editor Test'
        ]);

        $authors = $book->getContributorsByType('author');
        $editors = $book->getContributorsByType('editor');

        $this->assertCount(1, $authors);
        $this->assertCount(1, $editors);
        $this->assertEquals('Autor Test', $authors->first()->full_name);
        $this->assertEquals('Editor Test', $editors->first()->full_name);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_has_active_scope()
    {
        Book::factory()->create(['active' => true]);
        Book::factory()->create(['active' => false]);
        Book::factory()->create(['active' => true]);

        $activeBooks = Book::active()->get();

        $this->assertCount(2, $activeBooks);
        $this->assertTrue($activeBooks->every(fn($book) => $book->active));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_has_downloadable_scope()
    {
        Book::factory()->create(['downloadable' => true]);
        Book::factory()->create(['downloadable' => false]);
        Book::factory()->create(['downloadable' => true]);

        $downloadableBooks = Book::downloadable()->get();

        $this->assertCount(2, $downloadableBooks);
        $this->assertTrue($downloadableBooks->every(fn($book) => $book->downloadable));
    }
}
