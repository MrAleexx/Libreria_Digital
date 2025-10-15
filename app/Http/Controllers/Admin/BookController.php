<?php
// app/Http\Controllers\Admin\BookController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Language;
use App\Models\BookDetail;
use App\Models\BookContributor;
use App\Models\UserDownload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['categories', 'publisher', 'language'])->latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::active()->orderBy('sort_order')->get();
        $publishers = Publisher::active()->get();
        $languages = Language::active()->get();

        return view('admin.books.create', compact('categories', 'publishers', 'languages'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateBookData($request);
        $validated = $this->processFiles($request, $validated);
        $validated = $this->processCheckboxes($request, $validated);

        try {
            $book = Book::create($validated);

            if ($request->has('categories')) {
                $book->categories()->sync($request->input('categories'));
            }

            $this->createBookDetails($book, $request);
            $this->processContributors($book, $request->input('contributors', []));

            return redirect()->route('admin.books.index')
                ->with('success', 'Libro creado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear el libro: ' . $e->getMessage());
        }
    }

    public function show(Book $book)
    {
        $book->load([
            'categories',
            'contributors',
            'publisher',
            'language',
            'details',
            'physicalCopies'
        ]);

        $book->incrementViews();

        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = Category::active()->orderBy('sort_order')->get();
        $publishers = Publisher::active()->get();
        $languages = Language::active()->get();

        $book->load(['categories', 'contributors', 'details']);

        return view('admin.books.edit', compact('book', 'categories', 'publishers', 'languages'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $this->validateBookData($request, $book);
        $validated = $this->processFiles($request, $validated, $book);
        $validated = $this->processCheckboxes($request, $validated);

        try {
            $book->update($validated);

            if ($request->has('categories')) {
                $book->categories()->sync($request->input('categories'));
            } else {
                $book->categories()->detach();
            }

            $this->updateBookDetails($book, $request);

            return redirect()->route('admin.books.index')
                ->with('success', 'Libro actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el libro: ' . $e->getMessage());
        }
    }

    public function destroy(Book $book)
    {
        // Verificar si hay préstamos o reservas activas antes de eliminar
        if ($book->loans()->where('status', 'active')->exists()) {
            return back()->with('error', 'No se puede eliminar el libro porque tiene préstamos activos.');
        }

        if ($book->reservations()->whereIn('status', ['pending', 'ready_for_pickup'])->exists()) {
            return back()->with('error', 'No se puede eliminar el libro porque tiene reservas activas.');
        }

        $book->contributors()->delete();
        $book->categories()->detach();
        $book->contents()->delete();
        $book->details()->delete();
        $book->downloads()->delete();
        $book->physicalCopies()->delete();
        $book->reservations()->delete();

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        if ($book->pdf_file) {
            Storage::disk('public')->delete($book->pdf_file);
        }

        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Libro eliminado exitosamente.');
    }

    /**
     * Validación actualizada sin is_featured_new
     */
    private function validateBookData(Request $request, Book $book = null): array
    {
        $isbnRule = $book
            ? 'required|string|unique:books,isbn,' . $book->id
            : 'required|string|unique:books,isbn';

        return $request->validate([
            // INFORMACIÓN BÁSICA ESENCIAL
            'title' => 'required|string|max:255',
            'isbn' => $isbnRule,
            'publisher_id' => 'required|exists:publishers,id',
            'language_code' => 'required|exists:languages,code',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'pages' => 'required|integer|min:1',

            // CONTROL DE ACCESO Y TIPO
            'book_type' => 'required|in:digital,physical,both',
            'access_level' => 'required|in:free,premium,institutional',
            'copyright_status' => 'required|in:copyrighted,public_domain,creative_commons',
            'license_type' => 'nullable|string|max:100',

            // DESTACADOS Y ESTADOS (SOLO featured, NO is_featured_new)
            'is_active' => 'boolean',
            'downloadable' => 'boolean',
            'featured' => 'boolean',

            // ARCHIVOS
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',

            // DATOS OPCIONALES (para book_details)
            'description' => 'nullable|string',
            'edition' => 'nullable|string|max:100',
            'file_format' => 'nullable|string|max:10',
            'file_size' => 'nullable|string|max:50',
            'reading_age' => 'nullable|string|max:50',
            'deposito_legal' => 'nullable|string|max:50',
            'restrictions' => 'nullable|string',
            'notes' => 'nullable|string',

            // CATEGORÍAS
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',

            // CONTRIBUIDORES
            'contributors' => 'nullable|array',
            'contributors.*.full_name' => 'required|string|max:200',
            'contributors.*.contributor_type' => 'required|in:author,editor,translator,illustrator',
            'contributors.*.email' => 'nullable|email|max:100',
            'contributors.*.sequence_number' => 'nullable|integer|min:1',
            'contributors.*.biographical_note' => 'nullable|string',
        ]);
    }

    /**
     * Procesar archivos
     */
    private function processFiles(Request $request, array $validated, Book $book = null): array
    {
        if ($request->hasFile('cover_image')) {
            if ($book && $book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            if ($book && $book->pdf_file) {
                Storage::disk('public')->delete($book->pdf_file);
            }
            $validated['pdf_file'] = $request->file('pdf_file')->store('books/pdfs', 'public');
        }

        return $validated;
    }

    /**
     * Procesar checkboxes 
     */
    private function processCheckboxes(Request $request, array $validated): array
    {
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['downloadable'] = $request->boolean('downloadable', true);
        $validated['featured'] = $request->boolean('featured', false);

        return $validated;
    }

    /**
     * Procesar contribuidores
     */
    private function processContributors(Book $book, array $contributors): void
    {
        $book->contributors()->delete();

        foreach ($contributors as $index => $contributorData) {
            if (!empty($contributorData['full_name'])) {
                $book->contributors()->create([
                    'contributor_type' => $contributorData['contributor_type'] ?? 'author',
                    'full_name' => $contributorData['full_name'],
                    'email' => $contributorData['email'] ?? null,
                    'sequence_number' => $contributorData['sequence_number'] ?? ($index + 1),
                    'biographical_note' => $contributorData['biographical_note'] ?? null,
                ]);
            }
        }
    }

    /**
     * Crear detalles opcionales del libro
     */
    private function createBookDetails(Book $book, Request $request): void
    {
        BookDetail::create([
            'book_id' => $book->id,
            'description' => $request->input('description'),
            'edition' => $request->input('edition', '1ra'),
            'file_format' => $request->input('file_format', 'PDF'),
            'file_size' => $request->input('file_size'),
            'reading_age' => $request->input('reading_age'),
            'deposito_legal' => $request->input('deposito_legal'),
            'restrictions' => $request->input('restrictions'),
            'notes' => $request->input('notes'),
        ]);
    }

    /**
     * Actualizar detalles opcionales del libro
     */
    private function updateBookDetails(Book $book, Request $request): void
    {
        if ($book->details) {
            $book->details->update([
                'description' => $request->input('description'),
                'edition' => $request->input('edition', '1ra'),
                'file_format' => $request->input('file_format', 'PDF'),
                'file_size' => $request->input('file_size'),
                'reading_age' => $request->input('reading_age'),
                'deposito_legal' => $request->input('deposito_legal'),
                'restrictions' => $request->input('restrictions'),
                'notes' => $request->input('notes'),
            ]);
        } else {
            $this->createBookDetails($book, $request);
        }
    }

    /**
     * Método para manejar descargas
     */
    public function download(Book $book)
    {
        if (!$book->downloadable || !$book->is_active) {
            return back()->with('error', 'Este libro no está disponible para descarga.');
        }

        if (!$book->isAccessibleForUser(auth()->user())) {
            return back()->with('error', 'No tienes acceso para descargar este libro.');
        }

        if (auth()->check() && !auth()->user()->canDownload()) {
            return back()->with('error', 'Has alcanzado tu límite de descargas por hoy (máximo 5).');
        }

        $book->incrementDownloads();

        if (auth()->check()) {
            auth()->user()->incrementDownloads();

            UserDownload::create([
                'user_id' => auth()->id(),
                'book_id' => $book->id,
                'downloaded_at' => now(),
                'ip_address' => request()->ip(),
            ]);
        }

        if ($book->pdf_file && Storage::disk('public')->exists($book->pdf_file)) {
            $filename = \Str::slug($book->title) . '.pdf';
            return Storage::disk('public')->download($book->pdf_file, $filename);
        }

        return back()->with('error', 'El archivo PDF no está disponible.');
    }

    /**
     * Cambiar tipo de libro
     */
    public function updateBookType(Book $book, Request $request)
    {
        $request->validate([
            'book_type' => 'required|in:digital,physical,both',
        ]);

        $book->update(['book_type' => $request->book_type]);

        return back()->with('success', 'Tipo de libro actualizado exitosamente.');
    }

    /**
     * Cambiar estado de copyright
     */
    public function updateCopyrightStatus(Book $book, Request $request)
    {
        $request->validate([
            'copyright_status' => 'required|in:copyrighted,public_domain,creative_commons',
            'license_type' => 'nullable|string|max:100',
        ]);

        $book->update([
            'copyright_status' => $request->copyright_status,
            'license_type' => $request->license_type,
        ]);

        return back()->with('success', 'Estado de copyright actualizado exitosamente.');
    }

    /**
     * Toggle para featured
     */
    public function toggleFeatured(Book $book)
    {
        $book->update(['featured' => !$book->featured]);

        $status = $book->featured ? 'destacado' : 'quitado de destacados';
        return back()->with('success', "Libro {$status} exitosamente.");
    }

    /**
     * Toggle para activo/inactivo
     */
    public function toggleActive(Book $book)
    {
        $book->update(['is_active' => !$book->is_active]);

        $status = $book->is_active ? 'activado' : 'desactivado';
        return back()->with('success', "Libro {$status} exitosamente.");
    }

    /**
     * Creación rápida de editorial desde el formulario de libros
     */
    public function quickCreatePublisher(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:publishers',
                'city' => 'nullable|string|max:255',
                'country' => 'required|string|max:255|in:Perú,Argentina,México,España,Colombia,Chile',
            ]);

            $publisher = Publisher::create($validated);

            return response()->json([
                'success' => true,
                'publisher' => [
                    'id' => $publisher->id,
                    'name' => $publisher->name,
                    'city' => $publisher->city
                ],
                'message' => 'Editorial creada exitosamente'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la editorial: ' . $e->getMessage()
            ], 500);
        }
    }
}
