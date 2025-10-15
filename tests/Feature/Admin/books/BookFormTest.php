<?php
// tests/Feature/BookFormTest.php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Language;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BookFormTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        
        // Crear datos necesarios
        Category::factory()->count(3)->create();
        Publisher::factory()->create();
        Language::factory()->create(['code' => 'es']);
        
        Storage::fake('public');
    }

    /** @test */
    public function admin_can_create_book_with_required_fields()
    {
        $publisher = Publisher::first();
        $categories = Category::limit(2)->get();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.books.store'), [
                'title' => 'Nuevo Libro de Prueba',
                'isbn' => '1234567890123',
                'publisher_id' => $publisher->id,
                'language_code' => 'es',
                'pages' => 200,
                'publication_year' => 2024,
                'book_type' => 'digital',
                'access_level' => 'free',
                'copyright_status' => 'copyrighted',
                'is_active' => true,
                'downloadable' => true,
                'featured' => false,
                'categories' => $categories->pluck('id')->toArray(),
            ]);

        $response->assertRedirect(route('admin.books.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('books', [
            'title' => 'Nuevo Libro de Prueba',
            'isbn' => '1234567890123',
            'pages' => 200,
            'book_type' => 'digital',
        ]);

        $book = Book::first();
        $this->assertEquals(2, $book->categories->count());
    }

    /** @test */
    public function admin_can_create_book_using_factory_states()
    {
        $publisher = Publisher::first();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.books.store'), [
                'title' => 'Libro Premium Físico',
                'isbn' => '9876543210987',
                'publisher_id' => $publisher->id,
                'language_code' => 'es',
                'pages' => 350,
                'publication_year' => 2024,
                'book_type' => 'physical', // Usar tipo físico como en el factory
                'access_level' => 'premium', // Usar premium como en el factory
                'copyright_status' => 'creative_commons',
                'license_type' => 'CC BY-NC-SA 4.0',
                'is_active' => true,
                'downloadable' => false, // Libros físicos pueden no ser descargables
                'featured' => true,
            ]);

        $response->assertRedirect(route('admin.books.index'));

        $this->assertDatabaseHas('books', [
            'title' => 'Libro Premium Físico',
            'book_type' => 'physical',
            'access_level' => 'premium',
            'featured' => true,
        ]);
    }

    /** @test */
    public function admin_can_create_book_with_optional_details()
    {
        $publisher = Publisher::first();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.books.store'), [
                'title' => 'Libro con Detalles Opcionales',
                'isbn' => '1112223334445',
                'publisher_id' => $publisher->id,
                'language_code' => 'es',
                'pages' => 150,
                'publication_year' => 2024,
                'book_type' => 'digital',
                'access_level' => 'free',
                'copyright_status' => 'copyrighted',
                // Detalles opcionales
                'description' => 'Descripción detallada del libro',
                'edition' => '3ra Edición',
                'file_format' => 'PDF',
                'file_size' => '5.2 MB',
                'reading_age' => '18+',
                'deposito_legal' => 'B 54321-2024',
                'restrictions' => 'Uso educativo solamente',
                'notes' => 'Notas internas del administrador',
            ]);

        $response->assertRedirect(route('admin.books.index'));

        $book = Book::first();
        $this->assertNotNull($book->details);
        $this->assertEquals('3ra Edición', $book->details->edition);
        $this->assertEquals('Descripción detallada del libro', $book->details->description);
        $this->assertEquals('18+', $book->details->reading_age);
    }

    /** @test */
    public function admin_can_update_book_using_factory_states()
    {
        // Crear un libro inicial con factory
        $book = Book::factory()->create([
            'title' => 'Título Original',
            'book_type' => 'digital',
            'access_level' => 'free',
            'featured' => false,
        ]);

        $response = $this->actingAs($this->admin)
            ->put(route('admin.books.update', $book), [
                'title' => 'Título Actualizado a Premium',
                'isbn' => $book->isbn,
                'publisher_id' => $book->publisher_id,
                'language_code' => 'es',
                'pages' => 250,
                'publication_year' => 2024,
                'book_type' => 'both', // Cambiar a ambos tipos
                'access_level' => 'premium', // Cambiar a premium
                'copyright_status' => 'creative_commons',
                'license_type' => 'CC BY 4.0',
                'is_active' => true,
                'downloadable' => true,
                'featured' => true, // Marcar como destacado
            ]);

        $response->assertRedirect(route('admin.books.index'));
        $response->assertSessionHas('success');

        $book->refresh();
        $this->assertEquals('Título Actualizado a Premium', $book->title);
        $this->assertEquals('both', $book->book_type);
        $this->assertEquals('premium', $book->access_level);
        $this->assertEquals('creative_commons', $book->copyright_status);
        $this->assertTrue($book->featured);
    }

    /** @test */
    public function isbn_must_be_unique_on_create()
    {
        $existingBook = Book::factory()->create(['isbn' => '1234567890']);
        $publisher = Publisher::first();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.books.store'), [
                'title' => 'Nuevo Libro',
                'isbn' => '1234567890', // Mismo ISBN que el existente
                'publisher_id' => $publisher->id,
                'language_code' => 'es',
                'pages' => 100,
                'publication_year' => 2024,
                'book_type' => 'digital',
                'access_level' => 'free',
                'copyright_status' => 'copyrighted',
            ]);

        $response->assertSessionHasErrors('isbn');
    }
}