<?php

namespace App\Http\Controllers\Admin\books;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookLoan;
use App\Models\User;
use App\Http\Controllers\Admin\books\StoreLoanRequest;

class LoanController extends Controller
{
    public function index()
    {
        $loans = BookLoan::with(['user', 'physicalCopy.book'])
            ->filtered()
            ->latest()
            ->paginate(20);

        return view('admin.loans.index', compact('loans'));
    }

    public function create()
    {
        $books = Book::physical()->active()->get();
        $users = User::active()->get();

        return view('admin.loans.create', compact('books', 'users'));
    }

    public function store(StoreLoanRequest $request)
    {
        $book = Book::find($request->book_id);
        $availableCopy = $book->physicalCopies()->available()->first();

        if (!$availableCopy) {
            return back()->with('error', 'No hay ejemplares disponibles para este libro.');
        }

        $loan = BookLoan::create([
            'user_id' => $request->user_id,
            'physical_copy_id' => $availableCopy->id,
            'loan_date' => now(),
            'due_date' => $request->due_date,
            'status' => BookLoan::STATUS_ACTIVE,
        ]);

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

        return back()->with(
            'success',
            "Préstamo renovado. Nueva fecha: {$loan->due_date->format('d/m/Y')}"
        );
    }

    public function return(BookLoan $loan)
    {
        if ($loan->isReturned()) {
            return back()->with('error', 'Este préstamo ya fue devuelto.');
        }

        $loan->markAsReturned();

        return back()->with('success', 'Libro marcado como devuelto.');
    }

    public function reportOverdue(BookLoan $loan)
    {
        if (!$loan->isOverdue()) {
            return back()->with('error', 'Este préstamo no está atrasado.');
        }

        $loan->markAsOverdue();
        // TODO: Enviar notificación

        return back()->with('success', 'Préstamo marcado como atrasado.');
    }

    public function destroy(BookLoan $loan)
    {
        if ($loan->isActive()) {
            return back()->with('error', 'No se puede eliminar un préstamo activo.');
        }

        $loan->delete();
        return redirect()->route('admin.loans.index')
            ->with('success', 'Préstamo eliminado.');
    }
}
