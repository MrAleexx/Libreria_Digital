<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\Language;
use App\Models\Category;
use App\Models\BookDetail;
use App\Models\PhysicalCopy;
use App\Models\BookContributor;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $fillable = [
            'title',
            'isbn',
            'publisher_id',
            'language_code',
            'publication_year',
            'pages',
            'cover_image',
            'pdf_file',
            'book_type',
            'access_level',
            'copyright_status',
            'license_type',
            'is_active',
            'downloadable',
            'featured',
            'is_featured_new',
            'total_downloads',
            'total_views',
            'total_physical_copies',
            'available_physical_copies',
            'total_loans'
        ];

        $book = new Book();

        $this->assertEquals($fillable, $book->getFillable());
    }

    /** @test */
    /** @test */
    public function it_has_correct_casts()
    {
        $book = new Book();

        $expectedCasts = [
            'publication_year' => 'integer',
            'pages' => 'integer',
            'is_active' => 'boolean',
            'downloadable' => 'boolean',
            'featured' => 'boolean',
            'is_featured_new' => 'boolean',
            'total_downloads' => 'integer',
            'total_views' => 'integer',
            'total_physical_copies' => 'integer',
            'available_physical_copies' => 'integer',
            'total_loans' => 'integer',
        ];

        $actualCasts = $book->getCasts();

        // Remover el cast 'id' que Laravel agrega automáticamente
        unset($actualCasts['id']);

        $this->assertEquals($expectedCasts, $actualCasts);
    }

    /** @test */
    public function it_belongs_to_publisher()
    {
        $publisher = Publisher::factory()->create();
        $book = Book::factory()->create(['publisher_id' => $publisher->id]);

        $this->assertInstanceOf(Publisher::class, $book->publisher);
        $this->assertEquals($publisher->id, $book->publisher->id);
    }

    /** @test */
    public function it_belongs_to_language()
    {
        // Usar directamente un idioma que YA EXISTE en tu BD
        $languageCode = 'de'; // Alemán - existe en tu BD

        $book = Book::factory()->create(['language_code' => $languageCode]);

        $this->assertInstanceOf(Language::class, $book->language);
        $this->assertEquals($languageCode, $book->language->code);
    }

    /** @test */
    public function it_has_one_book_detail()
    {
        $book = Book::factory()->create();
        $detail = BookDetail::factory()->create(['book_id' => $book->id]);

        $this->assertInstanceOf(BookDetail::class, $book->details);
        $this->assertEquals($book->id, $book->details->book_id);
    }

    /** @test */
    public function it_has_many_physical_copies()
    {
        $book = Book::factory()->create();
        $copy1 = PhysicalCopy::factory()->create(['book_id' => $book->id]);
        $copy2 = PhysicalCopy::factory()->create(['book_id' => $book->id]);

        $this->assertCount(2, $book->physicalCopies);
        $this->assertTrue($book->physicalCopies->contains($copy1));
        $this->assertTrue($book->physicalCopies->contains($copy2));
    }

    /** @test */
    public function it_has_many_contributors()
    {
        $book = Book::factory()->create();
        $contributor1 = BookContributor::factory()->create(['book_id' => $book->id]);
        $contributor2 = BookContributor::factory()->create(['book_id' => $book->id]);

        $this->assertCount(2, $book->contributors);
        $this->assertTrue($book->contributors->contains($contributor1));
        $this->assertTrue($book->contributors->contains($contributor2));
    }

    /** @test */
    public function it_belongs_to_many_categories()
    {
        $book = Book::factory()->create();
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        $book->categories()->attach([$category1->id, $category2->id]);

        $this->assertCount(2, $book->categories);
        $this->assertTrue($book->categories->contains($category1));
        $this->assertTrue($book->categories->contains($category2));
    }

    /** @test */
    public function it_can_sync_categories()
    {
        $book = Book::factory()->create();
        $categories = Category::factory()->count(3)->create();

        $book->syncCategories($categories->pluck('id')->toArray());

        $this->assertCount(3, $book->categories);
    }

    /** @test */
    public function it_checks_if_available_for_loan()
    {
        $availableBook = Book::factory()->create(['available_physical_copies' => 2]);
        $unavailableBook = Book::factory()->create(['available_physical_copies' => 0]);

        $this->assertTrue($availableBook->isAvailableForLoan());
        $this->assertFalse($unavailableBook->isAvailableForLoan());
    }

    /** @test */
    public function it_calculates_available_copies_count()
    {
        $book = Book::factory()->create();
        PhysicalCopy::factory()->count(2)->create([
            'book_id' => $book->id,
            'status' => 'available'
        ]);
        PhysicalCopy::factory()->create([
            'book_id' => $book->id,
            'status' => 'loaned'
        ]);

        $this->assertEquals(2, $book->getAvailableCopiesCount());
    }

    /** @test */
    public function it_updates_physical_counters()
    {
        $book = Book::factory()->create();
        PhysicalCopy::factory()->count(3)->create([
            'book_id' => $book->id,
            'status' => 'available'
        ]);
        PhysicalCopy::factory()->count(1)->create([
            'book_id' => $book->id,
            'status' => 'loaned'
        ]);

        $book->updatePhysicalCounters();

        $this->assertEquals(4, $book->total_physical_copies);
        $this->assertEquals(3, $book->available_physical_copies);
    }

    /** @test */
    public function it_increments_views_and_downloads()
    {
        $book = Book::factory()->create(['total_views' => 5, 'total_downloads' => 3]);

        $book->incrementViews();
        $book->incrementDownloads();

        $this->assertEquals(6, $book->total_views);
        $this->assertEquals(4, $book->total_downloads);
    }

    /** @test */
    public function it_gets_all_authors()
    {
        $book = Book::factory()->create();
        BookContributor::factory()->create([
            'book_id' => $book->id,
            'contributor_type' => 'author',
            'full_name' => 'Author One',
            'sequence_number' => 1
        ]);
        BookContributor::factory()->create([
            'book_id' => $book->id,
            'contributor_type' => 'author',
            'full_name' => 'Author Two',
            'sequence_number' => 2
        ]);

        $this->assertEquals('Author One, Author Two', $book->all_authors);
    }

    /** @test */
    public function it_returns_sin_autor_when_no_authors()
    {
        $book = Book::factory()->create();

        $this->assertEquals('Sin autor', $book->all_authors);
    }

    /** @test */
    public function it_gets_main_author()
    {
        $book = Book::factory()->create();
        BookContributor::factory()->create([
            'book_id' => $book->id,
            'contributor_type' => 'author',
            'full_name' => 'Main Author',
            'sequence_number' => 1
        ]);

        $this->assertEquals('Main Author', $book->main_author);
    }

    /** @test */
    public function it_checks_accessibility_for_user()
    {
        $freeBook = Book::factory()->create(['access_level' => 'free']);
        $premiumBook = Book::factory()->create(['access_level' => 'premium']);

        $this->assertTrue($freeBook->isAccessibleForUser());
        $this->assertFalse($premiumBook->isAccessibleForUser(null));
    }

    /** @test */
    public function it_filters_by_scopes()
    {
        // Limpiar primero
        Book::query()->delete();

        // Crear libros con nombres únicos para debugging
        $active1 = Book::factory()->create(['title' => 'Active Book 1', 'is_active' => true]);
        $active2 = Book::factory()->create(['title' => 'Active Book 2', 'is_active' => true]);
        $inactive = Book::factory()->create(['title' => 'Inactive Book', 'is_active' => false]);
        $featured = Book::factory()->create(['title' => 'Featured Book', 'featured' => true, 'is_active' => true]);
        $notDownloadable = Book::factory()->create(['title' => 'Not Downloadable', 'downloadable' => false, 'is_active' => true]);

        // Debug: ver qué libros se crearon
        // dd(Book::all()->pluck('title', 'is_active'));

        $this->assertCount(4, Book::active()->get()); // active1, active2, featured, notDownloadable
        $this->assertCount(1, Book::featured()->get()); // solo featured
        $this->assertCount(4, Book::downloadable()->get()); // todos menos notDownloadable
    }

    /** @test */
    public function it_filters_by_book_type()
    {
        Book::factory()->create(['book_type' => 'digital']);
        Book::factory()->create(['book_type' => 'physical']);
        Book::factory()->create(['book_type' => 'both']);

        $this->assertCount(2, Book::digital()->get()); // digital + both
        $this->assertCount(2, Book::physical()->get()); // physical + both
        $this->assertCount(1, Book::byBookType('digital')->get());
    }

    /** @test */
    public function it_calculates_usage_stats()
    {
        $book = Book::factory()->create([
            'total_views' => 100,
            'total_downloads' => 25,
            'total_loans' => 10,
            'total_physical_copies' => 5,
            'available_physical_copies' => 3
        ]);

        $stats = $book->usage_stats;

        $this->assertEquals(100, $stats['total_views']);
        $this->assertEquals(25, $stats['total_downloads']);
        $this->assertEquals(25.0, $stats['download_ratio']); // 25/100 * 100
        $this->assertEquals(60.0, $stats['availability_ratio']); // 3/5 * 100
    }

    /** @test */
    public function it_gets_full_info_attribute()
    {
        $publisher = Publisher::factory()->create();

        // Usar un idioma que YA EXISTE en tu BD
        $book = Book::factory()->create([
            'publisher_id' => $publisher->id,
            'language_code' => 'it', // Italiano - existe en tu BD
            'book_type' => 'both',
            'access_level' => 'free'
        ]);

        $fullInfo = $book->full_info;

        $this->assertEquals($book->title, $fullInfo['basic']['title']);
        $this->assertEquals('both', $fullInfo['access']['book_type']);
        $this->assertArrayHasKey('stats', $fullInfo);
        $this->assertArrayHasKey('physical', $fullInfo);
    }

    /** @test */
    public function it_adds_author()
    {
        $book = Book::factory()->create();

        $contributor = $book->addAuthor('New Author', 1);

        $this->assertInstanceOf(BookContributor::class, $contributor);
        $this->assertEquals('author', $contributor->contributor_type);
        $this->assertEquals('New Author', $contributor->full_name);
        $this->assertEquals(1, $contributor->sequence_number);
    }

    /** @test */
    public function it_gets_contributors_by_type()
    {
        $book = Book::factory()->create();
        BookContributor::factory()->create([
            'book_id' => $book->id,
            'contributor_type' => 'author'
        ]);
        BookContributor::factory()->create([
            'book_id' => $book->id,
            'contributor_type' => 'editor'
        ]);

        $authors = $book->getContributorsByType('author');
        $editors = $book->getContributorsByType('editor');

        $this->assertCount(1, $authors);
        $this->assertCount(1, $editors);
        $this->assertEquals('author', $authors->first()->contributor_type);
    }
}
