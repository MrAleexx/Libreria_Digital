<?php
// tests/Feature/Admin/BookControllerTest.php

namespace Tests\Feature\Admin;

use App\Models\Book;
use App\Models\BookContributor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->actingAs($this->createAdminUser());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_display_books_index_page()
    {
        Book::factory()->count(3)->create();

        $response = $this->get(route('admin.books.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.books.index');
        $response->assertViewHas('books');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_display_book_creation_form()
    {
        $response = $this->get(route('admin.books.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.books.create');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_a_new_book_with_contributors()
    {
        $bookData = $this->getValidBookData();
        $contributorsData = $this->getValidContributorsData();

        // ✅ Asegurar que image sea un UploadedFile
        $bookData['image'] = UploadedFile::fake()->image('book-cover.jpg');

        $response = $this->post(route('admin.books.store'), array_merge(
            $bookData,
            ['contributors' => $contributorsData]
        ));

        $response->assertRedirect(route('admin.books.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('books', [
            'title' => $bookData['title'],
            'isbn' => $bookData['isbn'],
        ]);

        $book = Book::where('isbn', $bookData['isbn'])->first();
        $this->assertCount(2, $book->contributors);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_book_with_files()
    {
        $bookData = $this->getValidBookData();
        $bookData['image'] = UploadedFile::fake()->image('book-cover.jpg');
        $bookData['pdf_file'] = UploadedFile::fake()->create('document.pdf', 500);

        $response = $this->post(route('admin.books.store'), $bookData);

        // ✅ CORREGIDO: Verificar redirección correcta
        $response->assertRedirect(route('admin.books.index'));
        $response->assertSessionHas('success');

        $book = Book::where('isbn', $bookData['isbn'])->first();
        Storage::disk('public')->assertExists($book->image);
        Storage::disk('public')->assertExists($book->pdf_file);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_validates_required_fields_when_creating_book()
    {
        $response = $this->post(route('admin.books.store'), []);

        $response->assertSessionHasErrors([
            'title',
            'description',
            'isbn',
            'publisher',
            'language',
            'pages',
            'publication',
            'edition',
            'file_format',
            'price'
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_validates_isbn_uniqueness()
    {
        $existingBook = Book::factory()->create(['isbn' => '1234567890']);

        $bookData = $this->getValidBookData();
        $bookData['isbn'] = '1234567890';

        $response = $this->post(route('admin.books.store'), $bookData);

        $response->assertSessionHasErrors(['isbn']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_display_book_show_page()
    {
        $book = Book::factory()->create();

        $response = $this->get(route('admin.books.show', $book));

        $response->assertStatus(200);
        $response->assertViewIs('admin.books.show');
        $response->assertViewHas('book', $book);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_display_book_edit_form()
    {
        $book = Book::factory()->create();

        $response = $this->get(route('admin.books.edit', $book));

        $response->assertStatus(200);
        $response->assertViewIs('admin.books.edit');
        $response->assertViewHas('book', $book);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_update_existing_book()
    {
        $book = Book::factory()->create();
        $updateData = [
            'title' => 'Título Actualizado',
            'description' => 'Descripción actualizada',
            'isbn' => $book->isbn,
            'publisher' => 'Editorial Actualizada',
            'language' => 'es',
            'pages' => 300,
            'publication' => '2024-01-15',
            'edition' => '2da Edición',
            'file_format' => 'PDF',
            'price' => 29.99
        ];

        $response = $this->put(route('admin.books.update', $book), $updateData);

        // ✅ CORREGIDO: Verificar redirección correcta
        $response->assertRedirect(route('admin.books.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Título Actualizado',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_update_book_with_new_contributors()
    {
        $book = Book::factory()->create();
        BookContributor::factory()->count(2)->create(['book_id' => $book->id]);

        $updateData = $this->getValidBookData();
        $updateData['isbn'] = $book->isbn;
        $updateData['contributors'] = $this->getValidContributorsData();

        $updateData['image'] = UploadedFile::fake()->image('updated-book-cover.jpg');

        $response = $this->put(route('admin.books.update', $book), $updateData);

        $response->assertRedirect(route('admin.books.index'));

        $this->assertCount(2, $book->fresh()->contributors);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_update_book_with_new_files_and_delete_old_ones()
    {
        Storage::fake('public');

        $book = Book::factory()->create([
            'image' => 'books/old-image.jpg',
            'pdf_file' => 'books/pdfs/old-document.pdf'
        ]);

        Storage::disk('public')->put($book->image, 'fake image content');
        Storage::disk('public')->put($book->pdf_file, 'fake pdf content');

        $updateData = $this->getValidBookData();
        $updateData['isbn'] = $book->isbn;
        $updateData['image'] = UploadedFile::fake()->image('new-cover.jpg');
        $updateData['pdf_file'] = UploadedFile::fake()->create('new-document.pdf', 500);

        $response = $this->put(route('admin.books.update', $book), $updateData);

        // ✅ CORREGIDO: Verificar redirección correcta
        $response->assertRedirect(route('admin.books.index'));

        Storage::disk('public')->assertMissing($book->image);
        Storage::disk('public')->assertMissing($book->pdf_file);

        $updatedBook = $book->fresh();
        Storage::disk('public')->assertExists($updatedBook->image);
        Storage::disk('public')->assertExists($updatedBook->pdf_file);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_delete_book_with_contributors_and_files()
    {
        Storage::fake('public');

        $book = Book::factory()->create([
            'image' => 'books/book-image.jpg',
            'pdf_file' => 'books/pdfs/document.pdf'
        ]);

        BookContributor::factory()->count(2)->create(['book_id' => $book->id]);

        Storage::disk('public')->put($book->image, 'fake image content');
        Storage::disk('public')->put($book->pdf_file, 'fake pdf content');

        $response = $this->delete(route('admin.books.destroy', $book));

        // ✅ CORREGIDO: Verificar redirección correcta
        $response->assertRedirect(route('admin.books.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
        $this->assertDatabaseMissing('book_contributors', ['book_id' => $book->id]);
        Storage::disk('public')->assertMissing($book->image);
        Storage::disk('public')->assertMissing($book->pdf_file);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_processes_checkboxes_correctly()
    {
        $bookData = $this->getValidBookData();

        // ✅ Asegurar que image sea un UploadedFile
        $bookData['image'] = UploadedFile::fake()->image('book-cover.jpg');

        $bookData['is_new'] = true;
        $bookData['active'] = true;
        $bookData['downloadable'] = true;

        $response = $this->post(route('admin.books.store'), $bookData);

        $response->assertRedirect(route('admin.books.index'));

        $book = Book::where('isbn', $bookData['isbn'])->first();

        $this->assertTrue($book->is_new);
        $this->assertTrue($book->active);
        $this->assertTrue($book->downloadable);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_handles_validation_errors_gracefully()
    {
        $invalidData = [
            'title' => '',
            'price' => 'not-a-number',
            'publication' => 'invalid-date'
        ];

        $response = $this->post(route('admin.books.store'), $invalidData);

        $response->assertSessionHasErrors(['title', 'price', 'publication']);
        $response->assertStatus(302);
    }

    private function getValidBookData(): array
    {
        return [
            'title' => 'Libro de Prueba',
            'description' => 'Descripción del libro de prueba',
            'isbn' => $this->faker->unique()->isbn13(),
            'isbn13' => $this->faker->isbn13(),
            'deposito_legal' => 'DL-12345',
            'publisher' => 'Editorial de Prueba',
            'publisher_address' => 'Calle Falsa 123',
            'publisher_email' => 'editorial@test.com',
            'publisher_city' => 'Ciudad de Prueba',
            'language' => 'es',
            'pages' => 250,
            'publication' => '2024-01-01',
            'edition' => '1ra Edición',
            'file_format' => 'PDF',
            'file_size' => '2.5 MB',
            'price' => 24.99,
            'reading_age' => '18+',
            'publication_url' => 'https://ejemplo.com/libro',
            'image' => app()->environment('testing') ? 'default-book-cover.jpg' : $this->faker->imageUrl(),
            'pdf_file' => null,
            'is_new' => false,
            'active' => true,
            'downloadable' => true,
            'pre_order' => false,
            'published_at' => '2024-01-01 00:00:00'
        ];
    }

    private function getValidContributorsData(): array
    {
        return [
            [
                'contributor_type' => 'author',
                'full_name' => 'Juan Pérez',
                'email' => 'juan@example.com',
                'sequence_number' => 1,
                'biographical_note' => 'Autor reconocido'
            ],
            [
                'contributor_type' => 'editor',
                'full_name' => 'María García',
                'email' => 'maria@example.com',
                'sequence_number' => 2,
                'biographical_note' => 'Editora profesional'
            ]
        ];
    }

    private function createAdminUser()
    {
        return User::factory()->admin()->create([
            'email' => 'admin@ebooks.com',
            'password' => bcrypt('password'),
        ]);
    }
}
