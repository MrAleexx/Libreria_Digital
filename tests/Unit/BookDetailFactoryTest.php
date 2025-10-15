<?php
// tests/Unit/BookDetailFactoryTest.php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\BookDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookDetailFactoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_book_detail_with_factory()
    {
        $bookDetail = BookDetail::factory()->create();

        $this->assertNotNull($bookDetail);
        $this->assertNotNull($bookDetail->book_id);
        $this->assertNotEmpty($bookDetail->description);
        $this->assertNotEmpty($bookDetail->edition);
        $this->assertContains($bookDetail->file_format, ['PDF', 'EPUB', 'MOBI']);
        $this->assertNotEmpty($bookDetail->file_size);
        $this->assertNotEmpty($bookDetail->reading_age);
        $this->assertStringStartsWith('B ', $bookDetail->deposito_legal);
    }

    /** @test */
    public function it_can_create_book_detail_for_specific_book()
    {
        $book = Book::factory()->create();
        $bookDetail = BookDetail::factory()->forBook($book)->create();

        $this->assertEquals($book->id, $bookDetail->book_id);
        $this->assertEquals($book->id, $bookDetail->book->id);
    }

    /** @test */
    public function it_can_create_book_detail_with_detailed_description()
    {
        $bookDetail = BookDetail::factory()->withDetailedDescription()->create();

        $this->assertGreaterThan(200, strlen($bookDetail->description));
    }

    /** @test */
    public function it_can_create_book_detail_with_restrictions()
    {
        $bookDetail = BookDetail::factory()->withRestrictions()->create();

        $this->assertNotNull($bookDetail->restrictions);
        $this->assertNotEmpty($bookDetail->restrictions);
    }

    /** @test */
    public function it_can_create_book_detail_with_notes()
    {
        $bookDetail = BookDetail::factory()->withNotes()->create();

        $this->assertNotNull($bookDetail->notes);
        $this->assertNotEmpty($bookDetail->notes);
    }

    /** @test */
    public function it_can_create_first_edition_book()
    {
        $bookDetail = BookDetail::factory()->firstEdition()->create();

        $this->assertEquals('1ra', $bookDetail->edition);
    }

    /** @test */
    public function it_can_create_latest_edition_book()
    {
        $bookDetail = BookDetail::factory()->latestEdition()->create();

        $this->assertContains($bookDetail->edition, ['3ra', '4ta', '5ta']);
    }

    /** @test */
    public function it_can_create_large_file_book()
    {
        $bookDetail = BookDetail::factory()->largeFile()->create();

        $this->assertStringContainsString('MB', $bookDetail->file_size);
        $fileSize = (float) $bookDetail->file_size;
        $this->assertGreaterThanOrEqual(15, $fileSize);
    }

    /** @test */
    public function it_can_create_small_file_book()
    {
        $bookDetail = BookDetail::factory()->smallFile()->create();

        $this->assertTrue(
            str_contains($bookDetail->file_size, 'KB') || 
            ((float) $bookDetail->file_size) <= 2.0
        );
    }

    /** @test */
    public function it_can_create_children_book()
    {
        $bookDetail = BookDetail::factory()->forChildren()->create();

        $this->assertContains($bookDetail->reading_age, ['0-3', '4-6', '7-9']);
    }

    /** @test */
    public function it_can_create_young_adults_book()
    {
        $bookDetail = BookDetail::factory()->forYoungAdults()->create();

        $this->assertContains($bookDetail->reading_age, ['13-15', '16-18']);
    }

    /** @test */
    public function it_can_create_adults_book()
    {
        $bookDetail = BookDetail::factory()->forAdults()->create();

        $this->assertEquals('18+', $bookDetail->reading_age);
    }

    /** @test */
    public function it_can_create_all_ages_book()
    {
        $bookDetail = BookDetail::factory()->forAllAges()->create();

        $this->assertEquals('all', $bookDetail->reading_age);
    }

    /** @test */
    public function it_can_create_epub_format_book()
    {
        $bookDetail = BookDetail::factory()->epubFormat()->create();

        $this->assertEquals('EPUB', $bookDetail->file_format);
    }

    /** @test */
    public function it_can_create_mobi_format_book()
    {
        $bookDetail = BookDetail::factory()->mobiFormat()->create();

        $this->assertEquals('MOBI', $bookDetail->file_format);
    }

    /** @test */
    public function it_can_create_pdf_format_book()
    {
        $bookDetail = BookDetail::factory()->pdfFormat()->create();

        $this->assertEquals('PDF', $bookDetail->file_format);
    }
}