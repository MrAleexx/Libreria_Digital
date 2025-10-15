<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\BookContributor;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookContributorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_book()
    {
        $book = Book::factory()->create();
        $contributor = BookContributor::factory()->create(['book_id' => $book->id]);

        $this->assertInstanceOf(Book::class, $contributor->book);
        $this->assertEquals($book->id, $contributor->book_id);
    }

    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $contributor = new BookContributor();

        $this->assertEquals([
            'book_id',
            'contributor_type',
            'full_name',
            'email',
            'sequence_number',
            'biographical_note'
        ], $contributor->getFillable());
    }
}
