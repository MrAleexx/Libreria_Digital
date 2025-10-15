<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\BookContent;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookContentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_book()
    {
        $book = Book::factory()->create();
        $content = BookContent::factory()->create(['book_id' => $book->id]);

        $this->assertInstanceOf(Book::class, $content->book);
        $this->assertEquals($book->id, $content->book_id);
    }

    /** @test */
    public function it_has_correct_casts()
    {
        $content = new BookContent();

        $expectedCasts = [
            'chapter_number' => 'integer',
            'page_start' => 'integer',
            'page_end' => 'integer',
            'sort_order' => 'integer'
        ];

        $actualCasts = $content->getCasts();

        // Remover el cast 'id' que Laravel agrega automáticamente
        unset($actualCasts['id']);

        $this->assertEquals($expectedCasts, $actualCasts);
    }
}
