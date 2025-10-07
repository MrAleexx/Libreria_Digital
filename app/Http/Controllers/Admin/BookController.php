<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {

        $validated = $this->validateBookData($request);

        // Procesar archivos
        $validated = $this->processFiles($request, $validated);

        // Procesar checkboxes
        $validated = $this->processCheckboxes($request, $validated);


        if ($validated['is_free']) {
            $validated['price'] = 0;
        }

        try {
            // Crear libro
            $book = Book::create($validated);

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
        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $this->validateBookData($request, $book);

        // Procesar archivos (con eliminación de anteriores)
        $validated = $this->processFiles($request, $validated, $book);

        // Procesar checkboxes
        $validated = $this->processCheckboxes($request, $validated);

        if ($validated['is_free']) {
            $validated['price'] = 0;
        }

        try {
            // Actualizar libro
            $book->update($validated);

            return redirect()->route('admin.books.index')
                ->with('success', 'Libro actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el libro: ' . $e->getMessage());
        }
    }

    public function destroy(Book $book)
    {
        // Eliminar contribuidores primero (por integridad referencial)
        $book->contributors()->delete();

        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        if ($book->pdf_file) {
            Storage::disk('public')->delete($book->pdf_file);
        }

        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Libro eliminado exitosamente.');
    }

    /**
     * Validación de datos del libro
     */
    private function validateBookData(Request $request, Book $book = null): array
    {
        $isbnRule = $book
            ? 'required|string|unique:books,isbn,' . $book->id
            : 'required|string|unique:books,isbn';

        return $request->validate([
            // Información Básica
            'title' => 'required|string|max:255',
            'description' => 'required|string',

            // Identificadores
            'isbn' => $isbnRule,
            'isbn13' => 'nullable|string|max:20',
            'deposito_legal' => 'nullable|string|max:50',

            // Información Editorial
            'publisher' => 'required|string|max:255',
            'publisher_address' => 'nullable|string|max:500',
            'publisher_email' => 'nullable|email|max:100',
            'publisher_city' => 'nullable|string|max:100',

            // Detalles Técnicos
            'language' => 'required|string|max:50',
            'pages' => 'required|integer|min:1',
            'publication' => 'required|date',
            'edition' => 'required|string|max:100',
            'file_format' => 'required|string|max:50',
            'file_size' => 'nullable|string|max:50',

            // Información Comercial
            'price' => 'required|numeric|min:0',
            'is_free' => 'boolean',
            'reading_age' => 'nullable|string|max:50',
            'publication_url' => 'nullable|url|max:500',

            // Archivos
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',

            // Estados
            'is_new' => 'boolean',
            'active' => 'boolean',
            'downloadable' => 'boolean',
            'pre_order' => 'boolean',
            'is_free' => 'boolean', 
            'published_at' => 'nullable|date',
        ]);
    }

    /**
     * Procesar archivos
     */
    private function processFiles(Request $request, array $validated, Book $book = null): array
    {
        // Procesar imagen
        if ($request->hasFile('image')) {
            // Si estamos actualizando y existe imagen anterior, eliminarla
            if ($book && $book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $validated['image'] = $request->file('image')->store('books', 'public');
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
        $validated['is_new'] = $request->boolean('is_new');
        $validated['active'] = $request->boolean('active');
        $validated['downloadable'] = $request->boolean('downloadable');
        $validated['pre_order'] = $request->boolean('pre_order');
        $validated['is_free'] = $request->boolean('is_free');

        return $validated;
    }

    /**
     * Procesar contribuidores
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
}