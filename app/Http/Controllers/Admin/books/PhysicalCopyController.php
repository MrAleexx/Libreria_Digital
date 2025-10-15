<?php

namespace App\Http\Controllers\Admin\books;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\PhysicalCopy;
use Illuminate\Http\Request;

class PhysicalCopyController extends Controller
{
    public function index()
    {
        $query = PhysicalCopy::with('book');

        // Filtros
        if (request('status')) {
            $query->where('status', request('status'));
        }

        if (request('book_id')) {
            $query->where('book_id', request('book_id'));
        }

        $copies = $query->latest()->paginate(20);
        $books = Book::physical()->active()->get();

        return view('admin.physical-copies.index', compact('copies', 'books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'barcode' => 'required|string|unique:physical_copies,barcode',
            'copy_number' => 'required|integer|min:1',
            'location' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        // Verificar que el libro es físico
        $book = Book::find($validated['book_id']);
        if (!in_array($book->book_type, ['physical', 'both'])) {
            return back()->with('error', 'Solo se pueden agregar ejemplares a libros físicos.');
        }

        $copy = PhysicalCopy::create([
            'book_id' => $validated['book_id'],
            'barcode' => $validated['barcode'],
            'copy_number' => $validated['copy_number'],
            'location' => $validated['location'],
            'notes' => $validated['notes'],
            'status' => 'available',
        ]);

        // Actualizar contadores del libro
        $book->updatePhysicalCounters();

        return back()->with('success', 'Ejemplar físico agregado exitosamente.');
    }

    public function updateStatus(PhysicalCopy $copy, Request $request)
    {
        $request->validate([
            'status' => 'required|in:available,reserved,loaned,maintenance',
        ]);

        $oldStatus = $copy->status;
        $newStatus = $request->status;

        $copy->update(['status' => $newStatus]);

        // Actualizar contadores del libro
        $copy->book->updatePhysicalCounters();

        return back()->with('success', "Estado del ejemplar cambiado de {$oldStatus} a {$newStatus}.");
    }

    public function update(PhysicalCopy $copy, Request $request)
    {
        $validated = $request->validate([
            'barcode' => 'required|string|unique:physical_copies,barcode,' . $copy->id,
            'copy_number' => 'required|integer|min:1',
            'location' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $copy->update($validated);

        return back()->with('success', 'Ejemplar actualizado exitosamente.');
    }

    public function destroy(PhysicalCopy $copy)
    {
        if ($copy->isLoaned() || $copy->isReserved()) {
            return back()->with('error', 'No se puede eliminar un ejemplar que está prestado o reservado.');
        }

        $book = $copy->book;
        $copy->delete();

        // Actualizar contadores del libro
        $book->updatePhysicalCounters();

        return back()->with('success', 'Ejemplar eliminado exitosamente.');
    }

    public function scan()
    {
        return view('admin.physical-copies.scan');
    }

    public function processScan(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string',
        ]);

        $copy = PhysicalCopy::with(['book', 'activeLoan', 'activeReservation'])
            ->where('barcode', $request->barcode)
            ->first();

        if (!$copy) {
            return response()->json([
                'success' => false,
                'message' => 'Ejemplar no encontrado'
            ]);
        }

        return response()->json([
            'success' => true,
            'copy' => $copy,
            'book' => $copy->book,
            'current_loan' => $copy->activeLoan,
            'current_reservation' => $copy->activeReservation,
        ]);
    }
}
