<?php
// tests/Unit/BookFactoryTest.php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\Language;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookFactoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear solo los lenguajes que no existen
        $existingLanguages = [
            ['code' => 'es', 'name' => 'Spanish', 'native_name' => 'Español', 'is_active' => 1],
            ['code' => 'en', 'name' => 'English', 'native_name' => 'English', 'is_active' => 1],
            ['code' => 'fr', 'name' => 'French', 'native_name' => 'Français', 'is_active' => 1],
        ];

        foreach ($existingLanguages as $language) {
            if (!Language::where('code', $language['code'])->exists()) {
                Language::create($language);
            }
        }
    }

    /** @test */
    public function it_can_create_a_book_with_factory()
    {
        $book = Book::factory()->create();

        $this->assertNotNull($book);
        $this->assertNotEmpty($book->title);
        $this->assertNotEmpty($book->isbn);
        $this->assertIsInt($book->pages);
        $this->assertIsInt($book->publication_year);
        $this->assertContains($book->book_type, ['digital', 'physical', 'both']);
        $this->assertContains($book->access_level, ['free', 'premium', 'institutional']);
        $this->assertContains($book->copyright_status, ['copyrighted', 'public_domain', 'creative_commons']);

        // Verificar que is_featured_new no existe
        $this->assertFalse(isset($book->is_featured_new));
    }

    /** @test */
    public function it_can_create_book_with_publisher()
    {
        $publisher = Publisher::factory()->create();
        $book = Book::factory()->create(['publisher_id' => $publisher->id]);

        $this->assertEquals($publisher->id, $book->publisher_id);
        $this->assertNotNull($book->publisher);
    }

    /** @test */
    public function it_can_create_book_with_existing_language()
    {
        // Usar un lenguaje que ya existe en tu BD
        $book = Book::factory()->create(['language_code' => 'fr']);

        $this->assertEquals('fr', $book->language_code);
        $this->assertNotNull($book->language);
        $this->assertEquals('French', $book->language->name);
    }

    /** @test */
    public function it_can_create_book_with_different_existing_language()
    {
        // Probar con otro lenguaje existente
        $book = Book::factory()->create(['language_code' => 'en']);

        $this->assertEquals('en', $book->language_code);
        $this->assertNotNull($book->language);
        $this->assertEquals('English', $book->language->name);
    }

    /** @test */
    public function it_can_create_featured_book()
    {
        $book = Book::factory()->featured()->create();

        $this->assertTrue($book->featured);
    }

    /** @test */
    public function it_can_create_inactive_book()
    {
        $book = Book::factory()->inactive()->create();

        $this->assertFalse($book->is_active);
    }

    /** @test */
    public function it_can_create_premium_book()
    {
        $book = Book::factory()->premium()->create();

        $this->assertEquals('premium', $book->access_level);
    }

    /** @test */
    public function it_can_create_institutional_book()
    {
        $book = Book::factory()->institutional()->create();

        $this->assertEquals('institutional', $book->access_level);
    }

    /** @test */
    public function it_can_create_physical_book()
    {
        $book = Book::factory()->physical()->create();

        $this->assertEquals('physical', $book->book_type);
        $this->assertEquals(5, $book->total_physical_copies);
        $this->assertEquals(3, $book->available_physical_copies);
        $this->assertNull($book->pdf_file);
    }

    /** @test */
    public function it_can_create_digital_book()
    {
        $book = Book::factory()->digital()->create();

        $this->assertEquals('digital', $book->book_type);
        $this->assertEquals(0, $book->total_physical_copies);
        $this->assertEquals(0, $book->available_physical_copies);
    }

    /** @test */
    public function it_can_create_both_types_book()
    {
        $book = Book::factory()->both()->create();

        $this->assertEquals('both', $book->book_type);
        $this->assertEquals(3, $book->total_physical_copies);
        $this->assertEquals(2, $book->available_physical_copies);
    }

    /** @test */
    public function it_can_create_public_domain_book()
    {
        $book = Book::factory()->publicDomain()->create();

        $this->assertEquals('public_domain', $book->copyright_status);
        $this->assertNull($book->license_type);
    }

    /** @test */
    public function it_can_create_creative_commons_book()
    {
        $book = Book::factory()->creativeCommons()->create();

        $this->assertEquals('creative_commons', $book->copyright_status);
        $this->assertEquals('CC BY-NC-SA 4.0', $book->license_type);
    }

    /** @test */
    public function it_can_create_book_with_downloads()
    {
        $book = Book::factory()->withDownloads(42)->create();

        $this->assertEquals(42, $book->total_downloads);
    }

    /** @test */
    public function it_can_create_book_with_views()
    {
        $book = Book::factory()->withViews(150)->create();

        $this->assertEquals(150, $book->total_views);
    }

    /** @test */
    public function it_can_create_non_downloadable_book()
    {
        $book = Book::factory()->notDownloadable()->create();

        $this->assertFalse($book->downloadable);
    }
}
