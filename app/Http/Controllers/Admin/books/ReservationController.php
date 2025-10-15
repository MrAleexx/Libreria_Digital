<?php

namespace App\Http\Controllers\Admin\books;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookReservation;
use App\Models\User;
use App\Models\PhysicalCopy;
use App\Models\BookLoan;
use App\Http\Requests\Admin\books\StoreReservationRequest;
class ReservationController extends Controller
{
    public function index()
    {
        $reservations = BookReservation::with(['user', 'book', 'physicalCopy'])
            ->filtered()
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

    public function store(StoreReservationRequest $request)
    {
        $book = Book::find($request->book_id);

        if (!$book->isAvailableForLoan()) {
            return back()->with('error', 'No hay ejemplares disponibles.');
        }

        $availableCopy = $book->physicalCopies()->available()->first();

        $reservation = BookReservation::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'physical_copy_id' => $availableCopy->id,
            'reservation_date' => now(),
            'pickup_deadline' => $request->pickup_deadline,
            'status' => BookReservation::STATUS_PENDING,
        ]);

        $availableCopy->markAsReserved();

        return redirect()->route('admin.reservations.show', $reservation)
            ->with('success', 'Reserva creada exitosamente.');
    }

    public function show(BookReservation $reservation)
    {
        $reservation->load(['user', 'book', 'physicalCopy', 'loan']);
        return view('admin.reservations.show', compact('reservation'));
    }

    public function markReady(BookReservation $reservation)
    {
        if (!$reservation->isPending()) {
            return back()->with('error', 'Solo se pueden marcar reservas pendientes.');
        }

        $reservation->markAsReadyForPickup();
        return back()->with('success', 'Reserva lista para recoger.');
    }

    public function processPickup(BookReservation $reservation)
    {
        if (!$reservation->isReadyForPickup()) {
            return back()->with('error', 'La reserva debe estar lista para recoger.');
        }

        // Crear préstamo desde reserva
        $loan = $reservation->physicalCopy->loans()->create([
            'user_id' => $reservation->user_id,
            'reservation_id' => $reservation->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(BookLoan::LOAN_DURATION_DAYS),
            'status' => BookLoan::STATUS_ACTIVE,
        ]);

        $reservation->physicalCopy->markAsLoaned();
        $reservation->markAsPickedUp();

        return redirect()->route('admin.loans.show', $loan)
            ->with('success', 'Préstamo procesado exitosamente.');
    }

    public function cancel(BookReservation $reservation)
    {
        if (!$reservation->canBeCancelled()) {
            return back()->with('error', 'No se puede cancelar esta reserva.');
        }

        $reservation->markAsCancelled();
        return back()->with('success', 'Reserva cancelada.');
    }

    public function destroy(BookReservation $reservation)
    {
        if ($reservation->isActive()) {
            return back()->with('error', 'No se puede eliminar una reserva activa.');
        }

        $reservation->delete();
        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reserva eliminada.');
    }
}
