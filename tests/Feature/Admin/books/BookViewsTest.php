<?php
// tests/Feature/BookViewsTest.php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Language;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookViewsTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $librarian;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->librarian = User::factory()->create(['role' => 'librarian']);
        $this->user = User::factory()->create(['role' => 'user']);

        // Asegurarse de que los lenguajes básicos existan
        $this->seedBasicLanguages();
    }

    protected function seedBasicLanguages(): void
    {
        $languages = [
            ['code' => 'es', 'name' => 'Spanish', 'native_name' => 'Español', 'is_active' => 1],
            ['code' => 'en', 'name' => 'English', 'native_name' => 'English', 'is_active' => 1],
            ['code' => 'fr', 'name' => 'French', 'native_name' => 'Français', 'is_active' => 1],
        ];

        foreach ($languages as $language) {
            if (!Language::where('code', $language['code'])->exists()) {
                Language::create($language);
            }
        }
    }

    /** @test */
    public function admin_can_access_books_index_page()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.books.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.books.index');
        $response->assertSee('Gestión de Libros');
        $response->assertSee('Biblioteca Digital');
    }

    /** @test */
    public function books_index_page_shows_empty_state_when_no_books()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.books.index'));

        $response->assertSee('La biblioteca está vacía');
        $response->assertSee('Crear Primer Libro');
    }

    /** @test */
    public function books_index_page_shows_books_list()
    {
        // Usar tu factory existente
        $book = Book::factory()->create([
            'title' => 'Libro de Prueba Específico',
            'is_active' => true
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.books.index'));

        $response->assertSee('Libro de Prueba Específico');
        $response->assertSee($book->main_author); // Usar el accessor del modelo
    }

    /** @test */
    public function books_index_page_shows_categories()
    {
        $category = Category::factory()->create(['name' => 'Tecnología']);
        $book = Book::factory()->create();
        $book->categories()->attach($category);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.books.index'));

        $response->assertSee('Tecnología');
    }

    /** @test */
    public function books_index_page_shows_access_level_badges()
    {
        // Usar los métodos de estado de tu factory
        $freeBook = Book::factory()->create(['access_level' => 'free']);
        $premiumBook = Book::factory()->premium()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.books.index'));

        $response->assertSee('Free');
        $response->assertSee('Premium');
    }

    /** @test */
    public function books_index_page_shows_featured_badge()
    {
        // Usar el método featured de tu factory
        $featuredBook = Book::factory()->featured()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.books.index'));

        $response->assertSee('Destacado');
    }

    /** @test */
    public function books_index_page_shows_book_type_indicators()
    {
        $digitalBook = Book::factory()->digital()->create();
        $physicalBook = Book::factory()->physical()->create();
        $bothBook = Book::factory()->both()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.books.index'));

        // Verificar que los libros se muestran correctamente
        $response->assertSee($digitalBook->title);
        $response->assertSee($physicalBook->title);
        $response->assertSee($bothBook->title);
    }

    /** @test */
    public function books_index_page_shows_statistics()
    {
        // Usar los nuevos métodos de estado
        $popularBook = Book::factory()
            ->withDownloads(25)
            ->withViews(100)
            ->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.books.index'));

        $response->assertSee('25'); // descargas
        $response->assertSee('100'); // vistas
    }

    /** @test */
    public function admin_can_access_create_book_page()
    {
        // Crear datos necesarios para el formulario
        Category::factory()->count(2)->create();
        Publisher::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.books.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.books.create');
        $response->assertSee('Crear Nuevo Libro');
        $response->assertSee('Información Básica');
    }

    /** @test */
    public function create_book_page_contains_all_form_sections()
    {
        Category::factory()->count(2)->create();
        Publisher::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.books.create'));

        $response->assertSee('Título *');
        $response->assertSee('Categorías');
        $response->assertSee('Descripción');
        $response->assertSee('ISBN *');
        $response->assertSee('Editorial *');
        $response->assertSee('Idioma *');
        $response->assertSee('Páginas *');
        $response->assertSee('Año Publicación *');
        $response->assertSee('Detalles Opcionales');
        $response->assertSee('Nivel de Acceso *');
        $response->assertSee('Tipo de Libro *');
        $response->assertSee('Archivos');
    }

    /** @test */
    public function admin_can_access_edit_book_page()
    {
        $book = Book::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.books.edit', $book));

        $response->assertStatus(200);
        $response->assertViewIs('admin.books.edit');
        $response->assertSee('Editar Libro');
        $response->assertSee($book->title);
    }

    /** @test */
    public function edit_book_page_prefills_form_data()
    {
        $book = Book::factory()->create([
            'title' => 'Título Original del Libro',
            'isbn' => '1234567890',
            'pages' => 300,
            'publication_year' => 2023,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.books.edit', $book));

        $response->assertSee('Título Original del Libro');
        $response->assertSee('1234567890');
        $response->assertSee('300');
        $response->assertSee('2023');
    }

    /** @test */
    public function edit_book_page_shows_optional_details()
    {
        $book = Book::factory()->create();
        $book->details()->create([
            'edition' => '2da Edición Especial',
            'file_format' => 'PDF',
            'file_size' => '2.5 MB',
            'reading_age' => '18+',
            'deposito_legal' => 'B 12345-2023',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.books.edit', $book));

        $response->assertSee('2da Edición Especial');
        $response->assertSee('PDF');
        $response->assertSee('2.5 MB');
        $response->assertSee('18+');
        $response->assertSee('B 12345-2023');
    }

    /** @test */
    public function admin_can_access_show_book_page()
    {
        $book = Book::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.books.show', $book));

        $response->assertStatus(200);
        $response->assertViewIs('admin.books.show');
        $response->assertSee($book->title);
    }

    /** @test */
    public function show_book_page_increments_views()
    {
        $book = Book::factory()->create(['total_views' => 5]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.books.show', $book));

        $book->refresh();
        $this->assertEquals(6, $book->total_views);
    }

    /** @test */
    public function books_index_pagination_works()
    {
        Book::factory()->count(15)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.books.index'));

        $response->assertViewHas('books');
        $books = $response->viewData('books');
        $this->assertEquals(10, $books->count());
    }
}
