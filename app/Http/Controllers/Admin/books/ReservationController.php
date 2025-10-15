<?php

namespace App\Http\Controllers\Admin\books;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookReservation;
use App\Models\User;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = BookReservation::with(['user', 'book', 'physicalCopy'])
            ->latest()
            ->paginate(20);

        return view('admin.reservations.index', compact('reservations'));
    }

    public function create()
    {
        $books = Book::physical()->active()->get();
        $users = User::active()->get();

        return view('admin.reservations.create', compact('books', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'pickup_deadline' => 'required|date|after:today',
        ]);

        // Verificar disponibilidad
        $book = Book::find($validated['book_id']);
        if (!$book->isAvailableForLoan()) {
            return back()->with('error', 'No hay ejemplares disponibles para este libro.');
        }

        // Asignar ejemplar automáticamente
        $availableCopy = $book->physicalCopies()->available()->first();
        if (!$availableCopy) {
            return back()->with('error', 'No hay ejemplares disponibles en este momento.');
        }

        // Crear reserva
        $reservation = BookReservation::create([
            'user_id' => $validated['user_id'],
            'book_id' => $validated['book_id'],
            'physical_copy_id' => $availableCopy->id,
            'reservation_date' => now(),
            'pickup_deadline' => $validated['pickup_deadline'],
            'status' => 'pending',
        ]);

        // Marcar ejemplar como reservado
        $availableCopy->markAsReserved();

        return redirect()->route('admin.reservations.show', $reservation)
            ->with('success', 'Reserva creada exitosamente.');
    }

    public function show(BookReservation $reservation)
    {
        $reservation->load(['user', 'book', 'physicalCopy', 'loan']);
        return view('admin.reservations.show', compact('reservation'));
    }

    public function markReadyForPickup(BookReservation $reservation)
    {
        if (!$reservation->isPending()) {
            return back()->with('error', 'Solo se pueden marcar como listas las reservas pendientes.');
        }

        $reservation->markAsReadyForPickup();

        return back()->with('success', 'Reserva marcada como lista para recoger.');
    }

    public function processPickup(BookReservation $reservation)
    {
        if (!$reservation->isReadyForPickup()) {
            return back()->with('error', 'La reserva debe estar marcada como lista para recoger.');
        }

        // Crear préstamo
        $loan = $reservation->physicalCopy->loans()->create([
            'user_id' => $reservation->user_id,
            'reservation_id' => $reservation->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(14), // 2 semanas
            'status' => 'active',
        ]);

        // Marcar ejemplar como prestado
        $reservation->physicalCopy->markAsLoaned();

        // Marcar reserva como recogida
        $reservation->markAsPickedUp();

        return redirect()->route('admin.loans.show', $loan)
            ->with('success', 'Préstamo procesado exitosamente.');
    }

    public function cancel(BookReservation $reservation)
    {
        $reservation->markAsCancelled();
        return back()->with('success', 'Reserva cancelada exitosamente.');
    }

    public function destroy(BookReservation $reservation)
    {
        if ($reservation->isActive()) {
            return back()->with('error', 'No se puede eliminar una reserva activa.');
        }

        $reservation->delete();
        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reserva eliminada exitosamente.');
    }
}
