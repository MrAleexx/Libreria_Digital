<?php

namespace App\Http\Controllers\Admin\books;

use App\Http\Controllers\Controller;
use App\Models\BookLoan;
use App\Models\BookReservation;
use App\Models\PhysicalCopy;
use App\Models\User;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'pending_reservations' => BookReservation::pending()->count(),
            'ready_reservations' => BookReservation::readyForPickup()->count(),
            'active_loans' => BookLoan::active()->count(),
            'overdue_loans' => BookLoan::overdue()->count(),
            'available_copies' => PhysicalCopy::available()->count(),
            'total_copies' => PhysicalCopy::count(),
        ];

        $pendingReservations = BookReservation::pending()
            ->with(['user', 'book'])
            ->latest()
            ->take(10)
            ->get();

        $overdueLoans = BookLoan::overdue()
            ->with(['user', 'physicalCopy.book'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.library.dashboard', compact('stats', 'pendingReservations', 'overdueLoans'));
    }

    public function quickActions()
    {
        return view('admin.library.quick-actions');
    }

    public function processQuickLoan(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string',
            'user_dni' => 'required|string',
        ]);

        // Buscar usuario por DNI
        $user = User::where('dni', $request->user_dni)->first();
        if (!$user) {
            return back()->with('error', 'Usuario no encontrado.');
        }

        // Buscar ejemplar por código de barras
        $copy = PhysicalCopy::with('book')->where('barcode', $request->barcode)->first();
        if (!$copy) {
            return back()->with('error', 'Ejemplar no encontrado.');
        }

        if (!$copy->isAvailable()) {
            return back()->with('error', 'El ejemplar no está disponible.');
        }

        // Crear préstamo
        $loan = BookLoan::create([
            'user_id' => $user->id,
            'physical_copy_id' => $copy->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(14),
            'status' => 'active',
        ]);

        // Marcar como prestado
        $copy->markAsLoaned();

        return redirect()->route('admin.loans.show', $loan)
            ->with('success', 'Préstamo rápido procesado exitosamente.');
    }

    public function processQuickReturn(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string',
        ]);

        // Buscar ejemplar por código de barras
        $copy = PhysicalCopy::with(['activeLoan'])->where('barcode', $request->barcode)->first();

        if (!$copy) {
            return back()->with('error', 'Ejemplar no encontrado.');
        }

        if (!$copy->isLoaned()) {
            return back()->with('error', 'El ejemplar no está prestado.');
        }

        // Marcar como devuelto
        $copy->activeLoan->markAsReturned();

        return back()->with('success', 'Devolución procesada exitosamente.');
    }
}
