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
use Illuminate\Support\Facades\DB;
use App\Models\BookLoan;
use App\Models\BookReservation;
use App\Models\PhysicalCopy;
use App\Models\BookContent;

class BookController extends Controller
{
    public function index()
    {
        // Obtener categorías para los filtros
        $categories = Category::active()->orderBy('sort_order')->get();

        // Construir la consulta con filtros
        $query = Book::with(['categories', 'publisher', 'language']);

        // Aplicar filtros si existen
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        if (request('book_type')) {
            $query->where('book_type', request('book_type'));
        }

        if (request('is_active') !== null && request('is_active') !== '') {
            $query->where('is_active', request('is_active'));
        }

        if (request('category')) {
            $query->whereHas('categories', function ($q) {
                $q->where('categories.id', request('category'));
            });
        }

        $books = $query->latest()->paginate(10);

        return view('admin.books.index', compact('books', 'categories'));
    }

    public function create()
    {
        // DEBUG
        \Log::info('Accediendo a create book form');

        $categories = Category::active()->orderBy('sort_order')->get();
        $publishers = Publisher::active()->get();
        $languages = Language::active()->get();

        \Log::info('Datos para el formulario:', [
            'categories_count' => $categories->count(),
            'publishers_count' => $publishers->count(),
            'languages_count' => $languages->count()
        ]);

        return view('admin.books.create', compact('categories', 'publishers', 'languages'));
    }

    public function store(Request $request)
    {
        try {
            \Log::info('=== INICIANDO CREACIÓN DE LIBRO ===');
            \Log::info('Datos recibidos:', $request->all());

            // Validar datos básicos
            $validated = $this->validateBookData($request);

            \Log::info('Datos validados correctamente');

            // Procesar archivos (AHORA SÍ FUNCIONARÁ)
            $validated = $this->processFiles($request, $validated);

            // Verificar que la portada esté presente
            if (empty($validated['cover_image'])) {
                throw new \Exception('La portada del libro es obligatoria.');
            }

            $validated = $this->processCheckboxes($request, $validated);

            \Log::info('Datos finales para crear libro:', $validated);

            // Crear el libro básico
            $book = Book::create($validated);
            \Log::info('Libro creado con ID: ' . $book->id);

            // Procesar categorías
            if ($request->has('categories')) {
                $book->categories()->sync($request->input('categories'));
            }

            // Crear detalles del libro
            $this->createBookDetails($book, $request);

            return redirect()->route('admin.books.index')
                ->with('success', 'Libro creado exitosamente.');
        } catch (\Exception $e) {
            \Log::error('Error al crear libro: ' . $e->getMessage());
            return back()->with('error', 'Error al crear el libro: ' . $e->getMessage())
                ->withInput();
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
        try {
            \Log::info('=== INICIANDO ACTUALIZACIÓN DE LIBRO ===');
            \Log::info('Libro ID: ' . $book->id);
            \Log::info('Datos recibidos:', $request->all());
            \Log::info('Archivos recibidos:', [
                'cover_image' => $request->hasFile('cover_image'),
                'pdf_file' => $request->hasFile('pdf_file'),
                'delete_cover' => $request->input('delete_cover'),
                'delete_pdf' => $request->input('delete_pdf')
            ]);

            // Validar datos básicos
            $validated = $this->validateBookData($request, $book);
            \Log::info('✅ Validación exitosa', $validated);

            // DEBUG: Verificar campos de eliminación
            \Log::info('Campos de eliminación:', [
                'delete_cover' => $request->input('delete_cover'),
                'delete_pdf' => $request->input('delete_pdf')
            ]);

            // Manejar eliminación de archivos
            if ($request->has('delete_cover') && $request->delete_cover == '1') {
                \Log::info('🗑️  Eliminando portada...');
                if ($book->cover_image) {
                    Storage::disk('public')->delete($book->cover_image);
                    $validated['cover_image'] = null;
                    \Log::info('✅ Portada eliminada');
                }
            }

            if ($request->has('delete_pdf') && $request->delete_pdf == '1') {
                \Log::info('🗑️  Eliminando PDF...');
                if ($book->pdf_file) {
                    Storage::disk('public')->delete($book->pdf_file);
                    $validated['pdf_file'] = null;
                    \Log::info('✅ PDF eliminado');
                }
            }

            // Procesar nuevos archivos
            $validated = $this->processFiles($request, $validated, $book);
            \Log::info('✅ Archivos procesados', [
                'cover_image' => $validated['cover_image'] ?? 'No cambiado',
                'pdf_file' => $validated['pdf_file'] ?? 'No cambiado'
            ]);

            // Procesar checkboxes
            $validated = $this->processCheckboxes($request, $validated);
            \Log::info('✅ Checkboxes procesados', [
                'is_active' => $validated['is_active'],
                'downloadable' => $validated['downloadable'],
                'featured' => $validated['featured']
            ]);

            // Actualizar el libro
            \Log::info('🔄 Actualizando libro...');
            $book->update($validated);
            \Log::info('✅ Libro actualizado');

            // Sincronizar categorías
            \Log::info('🔄 Sincronizando categorías...');
            if ($request->has('categories')) {
                $book->categories()->sync($request->input('categories'));
                \Log::info('✅ Categorías sincronizadas: ' . implode(', ', $request->input('categories')));
            } else {
                $book->categories()->detach();
                \Log::info('✅ Categorías desvinculadas');
            }

            // Actualizar detalles
            \Log::info('🔄 Actualizando detalles del libro...');
            $this->updateBookDetails($book, $request);
            \Log::info('✅ Detalles actualizados');

            \Log::info('=== ACTUALIZACIÓN COMPLETADA EXITOSAMENTE ===');

            return redirect()->route('admin.books.index')
                ->with('success', 'Libro actualizado exitosamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('❌ Error de validación en update:', $e->errors());
            return back()->with('error', 'Error en el formulario: ' . implode(', ', $e->errors()))
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('❌ Error general en update: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Error al actualizar el libro: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function deleteBookFiles(Book $book): void
    {
        try {
            if ($book->cover_image) {
                \Log::info("Eliminando imagen: {$book->cover_image}");
                if (Storage::disk('public')->exists($book->cover_image)) {
                    Storage::disk('public')->delete($book->cover_image);
                    \Log::info("Imagen eliminada: {$book->cover_image}");
                } else {
                    \Log::warning("Imagen no encontrada: {$book->cover_image}");
                }
            }

            if ($book->pdf_file) {
                \Log::info("Eliminando PDF: {$book->pdf_file}");
                if (Storage::disk('public')->exists($book->pdf_file)) {
                    Storage::disk('public')->delete($book->pdf_file);
                    \Log::info("PDF eliminado: {$book->pdf_file}");
                } else {
                    \Log::warning("PDF no encontrado: {$book->pdf_file}");
                }
            }
        } catch (\Exception $e) {
            \Log::error('Error al eliminar archivos: ' . $e->getMessage());
            // Continuar con la eliminación aunque falle la eliminación de archivos
        }
    }

    public function destroy(Book $book)
    {
        try {
            \Log::info("=== INICIANDO ELIMINACIÓN DEL LIBRO ===");
            \Log::info("Libro ID: {$book->id}, Título: {$book->title}");

            // VERIFICACIONES CORREGIDAS - Usar consultas directas
            \Log::info("Verificando préstamos activos...");
            $activeLoansCount = BookLoan::whereHas('physicalCopy', function ($query) use ($book) {
                $query->where('book_id', $book->id);
            })->where('status', 'active')->count();

            if ($activeLoansCount > 0) {
                \Log::warning("No se puede eliminar: {$activeLoansCount} préstamos activos");
                return back()->with('error', "No se puede eliminar el libro porque tiene {$activeLoansCount} préstamo(s) activo(s).");
            }

            \Log::info("Verificando reservas activas...");
            $activeReservationsCount = BookReservation::where('book_id', $book->id)
                ->whereIn('status', ['pending', 'ready_for_pickup'])
                ->count();

            if ($activeReservationsCount > 0) {
                \Log::warning("No se puede eliminar: {$activeReservationsCount} reservas activas");
                return back()->with('error', "No se puede eliminar el libro porque tiene {$activeReservationsCount} reserva(s) activa(s).");
            }

            \Log::info("Iniciando eliminación en transacción...");

            // Usar transacción para asegurar consistencia
            DB::transaction(function () use ($book) {

                // ELIMINACIÓN EN ORDEN CORRECTO PARA EVITAR ERRORES DE FK

                \Log::info("1. Eliminando descargas de usuarios...");
                UserDownload::where('book_id', $book->id)->delete();

                \Log::info("2. Eliminando préstamos relacionados...");
                // Obtener IDs de ejemplares físicos primero
                $physicalCopyIds = PhysicalCopy::where('book_id', $book->id)->pluck('id');

                if ($physicalCopyIds->isNotEmpty()) {
                    \Log::info("Eliminando préstamos para {$physicalCopyIds->count()} ejemplares físicos...");
                    BookLoan::whereIn('physical_copy_id', $physicalCopyIds)->delete();
                }

                \Log::info("3. Eliminando reservas...");
                BookReservation::where('book_id', $book->id)->delete();

                \Log::info("4. Eliminando ejemplares físicos...");
                PhysicalCopy::where('book_id', $book->id)->delete();

                \Log::info("5. Eliminando contribuidores...");
                BookContributor::where('book_id', $book->id)->delete();

                \Log::info("6. Eliminando contenido/índice...");
                BookContent::where('book_id', $book->id)->delete();

                \Log::info("7. Eliminando detalles opcionales...");
                BookDetail::where('book_id', $book->id)->delete();

                \Log::info("8. Desvinculando categorías...");
                DB::table('book_category')->where('book_id', $book->id)->delete();

                \Log::info("9. Eliminando archivos...");
                $this->deleteBookFiles($book);

                \Log::info("10. Eliminando libro de la base de datos...");
                $book->delete();
            });

            \Log::info("=== LIBRO ELIMINADO EXITOSAMENTE ===");

            return redirect()->route('admin.books.index')
                ->with('success', 'Libro eliminado exitosamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Error de base de datos al eliminar libro: ' . $e->getMessage());
            \Log::error('SQL: ' . $e->getSql());
            \Log::error('Bindings: ' . json_encode($e->getBindings()));

            return back()->with('error', 'Error de base de datos al eliminar el libro: ' . $e->getMessage());
        } catch (\Exception $e) {
            \Log::error('Error general al eliminar libro: ' . $e->getMessage());
            \Log::error('Trace: ' . $e->getTraceAsString());

            return back()->with('error', 'Error al eliminar el libro: ' . $e->getMessage());
        }
    }

    /**
     * Validación actualizada con mejor debug
     */
    private function validateBookData(Request $request, Book $book = null): array
    {
        $isbnRule = $book
            ? 'required|string|unique:books,isbn,' . $book->id
            : 'required|string|unique:books,isbn';

        $rules = [
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
            'is_active' => 'sometimes|boolean',
            'downloadable' => 'sometimes|boolean',
            'featured' => 'sometimes|boolean',

            // QUITAMOS las reglas de archivos porque las maneja Livewire
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',

            // DATOS OPCIONALES
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
        ];

        $messages = [
            'title.required' => 'El título del libro es obligatorio',
            'isbn.required' => 'El ISBN es obligatorio',
            'isbn.unique' => 'El ISBN ya existe en el sistema',
            'publisher_id.required' => 'La editorial es obligatoria',
            'publisher_id.exists' => 'La editorial seleccionada no existe',
            'language_code.required' => 'El idioma es obligatorio',
            'language_code.exists' => 'El idioma seleccionado no existe',
            'publication_year.required' => 'El año de publicación es obligatorio',
            'pages.required' => 'El número de páginas es obligatorio',
            'book_type.required' => 'El tipo de libro es obligatorio',
            'access_level.required' => 'El nivel de acceso es obligatorio',
            'copyright_status.required' => 'El estado de copyright es obligatorio',
        ];

        \Log::info('Reglas de validación aplicadas');

        try {
            $validated = $request->validate($rules, $messages);
            \Log::info('Validación exitosa');
            return $validated;
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Error de validación:', $e->errors());
            throw $e;
        }
    }

    /**
     * Procesar archivos
     */
    private function processFiles(Request $request, array $validated, Book $book = null): array
    {
        \Log::info('📁 Procesando archivos...', [
            'has_cover_image' => $request->hasFile('cover_image'),
            'has_pdf_file' => $request->hasFile('pdf_file'),
            'book_cover' => $book ? $book->cover_image : 'No book'
        ]);

        if ($request->hasFile('cover_image')) {
            \Log::info('🖼️  Procesando nueva portada...');
            if ($book && $book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
                \Log::info('🗑️  Portada anterior eliminada: ' . $book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('books', 'public');
            \Log::info('✅ Nueva portada guardada: ' . $validated['cover_image']);
        }

        if ($request->hasFile('pdf_file')) {
            \Log::info('📄 Procesando nuevo PDF...');
            if ($book && $book->pdf_file) {
                Storage::disk('public')->delete($book->pdf_file);
                \Log::info('🗑️  PDF anterior eliminado: ' . $book->pdf_file);
            }
            $validated['pdf_file'] = $request->file('pdf_file')->store('books/pdfs', 'public');
            \Log::info('✅ Nuevo PDF guardado: ' . $validated['pdf_file']);
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

        \Log::info('Checkboxes procesados:', [
            'is_active' => $validated['is_active'],
            'downloadable' => $validated['downloadable'],
            'featured' => $validated['featured']
        ]);

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
        \Log::info('📝 Actualizando detalles del libro...', [
            'description' => $request->input('description'),
            'edition' => $request->input('edition'),
            'file_format' => $request->input('file_format'),
            'file_size' => $request->input('file_size'),
            'reading_age' => $request->input('reading_age'),
            'deposito_legal' => $request->input('deposito_legal'),
            'restrictions' => $request->input('restrictions'),
            'notes' => $request->input('notes')
        ]);

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
            \Log::info('✅ Detalles existentes actualizados');
        } else {
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
            \Log::info('✅ Nuevos detalles creados');
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

    public function getPhysicalStats(Book $book)
    {
        return response()->json([
            'total_copies' => $book->total_physical_copies,
            'available_copies' => $book->available_physical_copies,
            'total_loans' => $book->total_loans,
        ]);
    }
}
