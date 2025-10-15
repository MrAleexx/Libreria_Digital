<?php
// app/Http\Controllers\Admin\BookController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Language;
use App\Models\BookDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        // Cargar relaciones normalizadas
        $books = Book::with(['categories', 'publisher', 'language'])->latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        // Obtener datos de relaciones
        $categories = Category::active()->orderBy('sort_order')->get();
        $publishers = Publisher::active()->get();
        $languages = Language::active()->get();

        return view('admin.books.create', compact('categories', 'publishers', 'languages'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateBookData($request);

        // Procesar archivos
        $validated = $this->processFiles($request, $validated);

        // Procesar checkboxes
        $validated = $this->processCheckboxes($request, $validated);

        try {
            // Crear libro con estructura normalizada
            $book = Book::create($validated);

            // Procesar categorías
            if ($request->has('categories')) {
                $book->categories()->sync($request->input('categories'));
            }

            // Crear detalles opcionales
            $this->createBookDetails($book, $request);

            // Procesar contribuidores
            $this->processContributors($book, $request->input('contributors', []));

            return redirect()->route('admin.books.index')
                ->with('success', 'Libro creado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear el libro: ' . $e->getMessage());
        }
    }

    public function show(Book $book)
    {
        // Cargar todas las relaciones normalizadas
        $book->load([
            'categories',
            'contributors',
            'publisher',
            'language',
            'details'
        ]);

        // Incrementar vistas al mostrar el libro
        $book->incrementViews();

        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        // Obtener datos de relaciones
        $categories = Category::active()->orderBy('sort_order')->get();
        $publishers = Publisher::active()->get();
        $languages = Language::active()->get();

        // Cargar relaciones normalizadas
        $book->load(['categories', 'contributors', 'details']);

        return view('admin.books.edit', compact('book', 'categories', 'publishers', 'languages'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $this->validateBookData($request, $book);

        // Procesar archivos (con eliminación de anteriores)
        $validated = $this->processFiles($request, $validated, $book);

        // Procesar checkboxes
        $validated = $this->processCheckboxes($request, $validated);

        try {
            // Actualizar libro
            $book->update($validated);

            // Sincronizar categorías
            if ($request->has('categories')) {
                $book->categories()->sync($request->input('categories'));
            } else {
                $book->categories()->detach();
            }

            // Actualizar detalles opcionales
            $this->updateBookDetails($book, $request);

            return redirect()->route('admin.books.index')
                ->with('success', 'Libro actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el libro: ' . $e->getMessage());
        }
    }

    public function destroy(Book $book)
    {
        // Eliminar todas las relaciones normalizadas
        $book->contributors()->delete();
        $book->categories()->detach();
        $book->contents()->delete();
        $book->details()->delete();
        $book->downloads()->delete();

        // Eliminar archivos con nombres correctos
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
     * Validación para estructura normalizada
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

            // DESTACADOS Y ESTADOS
            'is_active' => 'boolean',
            'downloadable' => 'boolean',
            'featured' => 'boolean',
            'is_featured_new' => 'boolean',

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
        ]);
    }

    /**
     * Procesar archivos
     */
    private function processFiles(Request $request, array $validated, Book $book = null): array
    {
        // Procesar imagen (cover_image en lugar de image)
        if ($request->hasFile('cover_image')) {
            // Si estamos actualizando y existe imagen anterior, eliminarla
            if ($book && $book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        // Procesar PDF
        if ($request->hasFile('pdf_file')) {
            // Si estamos actualizando y existe PDF anterior, eliminarlo
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
        $validated['is_featured_new'] = $request->boolean('is_featured_new', false);

        return $validated;
    }

    /**
     * Procesar contribuidores (igual que antes)
     */
    private function processContributors(Book $book, array $contributors): void
    {
        // Eliminar contribuidores existentes
        $book->contributors()->delete();

        // Agregar nuevos contribuidores
        foreach ($contributors as $contributorData) {
            if (!empty($contributorData['full_name'])) {
                $book->contributors()->create([
                    'contributor_type' => $contributorData['contributor_type'] ?? 'author',
                    'full_name' => $contributorData['full_name'],
                    'email' => $contributorData['email'] ?? null,
                    'sequence_number' => $contributorData['sequence_number'] ?? 1,
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
            'edition' => $request->input('edition'),
            'file_format' => $request->input('file_format'),
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
                'edition' => $request->input('edition'),
                'file_format' => $request->input('file_format'),
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
        // Verificar si el libro es descargable
        if (!$book->downloadable || !$book->is_active) {
            return back()->with('error', 'Este libro no está disponible para descarga.');
        }

        // Verificar acceso del usuario
        if (!$book->isAccessibleForUser(auth()->user())) {
            return back()->with('error', 'No tienes acceso para descargar este libro.');
        }

        // Verificar límite de descargas del usuario
        if (auth()->check() && !auth()->user()->canDownload()) {
            return back()->with('error', 'Has alcanzado tu límite de descargas por hoy (máximo 5).');
        }

        // Incrementar contador de descargas del libro
        $book->incrementDownloads();

        // Incrementar contador de descargas del usuario
        if (auth()->check()) {
            auth()->user()->incrementDownloads();

            // Registrar descarga en UserDownload
            \App\Models\UserDownload::create([
                'user_id' => auth()->id(),
                'book_id' => $book->id,
                'downloaded_at' => now(),
                'ip_address' => request()->ip(),
            ]);
        }

        // Descargar archivo
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
}
