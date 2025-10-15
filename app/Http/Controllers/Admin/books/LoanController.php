<?php

namespace App\Http\Controllers\Admin\books;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookLoan;
use App\Models\User;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $query = BookLoan::with(['user', 'physicalCopy.book']);

        // Filtros
        if (request('filter') == 'active') {
            $query->active();
        } elseif (request('filter') == 'overdue') {
            $query->overdue();
        } elseif (request('filter') == 'returned') {
            $query->returned();
        }

        $loans = $query->latest()->paginate(20);

        return view('admin.loans.index', compact('loans'));
    }

    public function create()
    {
        $books = Book::physical()->active()->get();
        $users = User::active()->get();

        return view('admin.loans.create', compact('books', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'due_date' => 'required|date|after:today',
        ]);

        // Buscar ejemplar disponible
        $book = Book::find($validated['book_id']);
        $availableCopy = $book->physicalCopies()->available()->first();

        if (!$availableCopy) {
            return back()->with('error', 'No hay ejemplares disponibles para este libro.');
        }

        // Crear préstamo directo (sin reserva)
        $loan = BookLoan::create([
            'user_id' => $validated['user_id'],
            'physical_copy_id' => $availableCopy->id,
            'loan_date' => now(),
            'due_date' => $validated['due_date'],
            'status' => 'active',
        ]);

        // Marcar ejemplar como prestado
        $availableCopy->markAsLoaned();

        return redirect()->route('admin.loans.show', $loan)
            ->with('success', 'Préstamo creado exitosamente.');
    }

    public function show(BookLoan $loan)
    {
        $loan->load(['user', 'physicalCopy.book', 'reservation']);
        return view('admin.loans.show', compact('loan'));
    }

    public function renew(BookLoan $loan)
    {
        if (!$loan->canBeRenewed()) {
            return back()->with('error', 'Este préstamo no puede ser renovado.');
        }

        $loan->renew();

        return back()->with('success', 'Préstamo renovado exitosamente. Nueva fecha de devolución: ' . $loan->due_date->format('d/m/Y'));
    }

    public function return(BookLoan $loan)
    {
        if ($loan->isReturned()) {
            return back()->with('error', 'Este préstamo ya fue devuelto.');
        }

        $loan->markAsReturned();

        return back()->with('success', 'Libro marcado como devuelto exitosamente.');
    }

    public function extend(BookLoan $loan, Request $request)
    {
        $request->validate([
            'new_due_date' => 'required|date|after:' . $loan->due_date->format('Y-m-d'),
        ]);

        $loan->update(['due_date' => $request->new_due_date]);

        return back()->with('success', 'Fecha de devolución extendida exitosamente.');
    }

    public function reportOverdue(BookLoan $loan)
    {
        if (!$loan->isOverdue()) {
            return back()->with('error', 'Este préstamo no está atrasado.');
        }

        $loan->markAsOverdue();

        // TODO: Enviar notificación al usuario
        // Mail::to($loan->user->email)->send(new OverdueNoticeMail($loan));

        return back()->with('success', 'Préstamo marcado como atrasado y notificación enviada.');
    }
}
