<?php
// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDownload;
use App\Models\BookLoan;
use App\Models\BookReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::with(['creator', 'activeLoans', 'pendingReservations'])
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        $user->load([
            'creator',
            'orders' => function ($query) {
                $query->with(['orderDetails.book', 'payment'])->latest();
            },
            'downloads' => function ($query) {
                $query->with('book')->latest()->take(10);
            },
            // Cargar relaciones del sistema físico
            'activeLoans' => function ($query) {
                $query->with(['physicalCopy.book', 'physicalCopy.book.details'])->latest();
            },
            'pendingReservations' => function ($query) {
                $query->with(['book', 'book.details'])->latest();
            },
            'bookLoans' => function ($query) {
                $query->with(['physicalCopy.book'])->latest()->take(5);
            }
        ]);

        // Estadísticas de descargas
        $downloadStats = [
            'today' => $user->downloads()->whereDate('downloaded_at', today())->count(),
            'total' => $user->downloads()->count(),
            'remaining' => max(0, 5 - $user->downloads_today)
        ];

        // Estadísticas del sistema físico
        $physicalStats = [
            'active_loans' => $user->activeLoans()->count(),
            'overdue_loans' => $user->bookLoans()->overdue()->count(),
            'pending_reservations' => $user->pendingReservations()->count(),
            'total_loans' => $user->bookLoans()->count(),
        ];

        return view('admin.users.show', compact('user', 'downloadStats', 'physicalStats'));
    }

    // Crear usuario individual
    public function create()
    {
        $this->authorize('create', User::class);

        $roles = [
            'admin' => 'Administrador',
            'librarian' => 'Bibliotecario',
            'user' => 'Usuario Normal'
        ];

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'institutional_email' => ['nullable', 'email', 'unique:users'],
            'role' => 'required|in:admin,librarian,user',
            'dni' => ['required', 'numeric', 'digits:8', 'unique:users'],
            'phone' => ['required', 'numeric', 'digits:9', 'unique:users'],
            'send_credentials' => 'boolean',
        ]);

        // Generar contraseña temporal
        $tempPassword = Str::random(10);

        $userData = [
            'name' => $validated['name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'institutional_email' => $validated['institutional_email'] ?? null,
            'dni' => $validated['dni'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'password' => Hash::make($tempPassword),
            'is_temp_password' => true,
            'temp_password_expires_at' => now()->addDays(7),
            'created_by' => auth()->id(),
            'is_active' => true,
        ];

        $user = User::create($userData);

        // TODO: Enviar email con credenciales si send_credentials es true
        if ($request->boolean('send_credentials')) {
            // Mail::to($user->email)->send(new UserCredentialsMail($user, $tempPassword));
        }

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Usuario creado exitosamente.')
            ->with('temp_password', $tempPassword)
            ->with('user_email', $user->email)
            ->with('show_password_modal', true);
    }

    public function clearTempPassword(Request $request)
    {
        $request->session()->forget(['temp_password', 'user_email', 'show_password_modal']);
        return response()->json(['success' => true]);
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $roles = [
            'admin' => 'Administrador',
            'librarian' => 'Bibliotecario',
            'user' => 'Usuario Normal'
        ];

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'institutional_email' => ['nullable', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:admin,librarian,user',
            'is_active' => 'boolean',
            'dni' => ['required', 'numeric', 'digits:8', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'numeric', 'digits:9', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'reset_temp_password' => 'boolean',
        ]);

        // Preparar datos para actualizar
        $updateData = [
            'name' => $validated['name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'institutional_email' => $validated['institutional_email'] ?? null,
            'role' => $validated['role'],
            'is_active' => $validated['is_active'] ?? true,
            'dni' => $validated['dni'],
            'phone' => $validated['phone'],
        ];

        $tempPassword = null;

        // Manejar contraseña temporal
        if ($request->boolean('reset_temp_password')) {
            $tempPassword = Str::random(10);
            $updateData['password'] = Hash::make($tempPassword);
            $updateData['is_temp_password'] = true;
            $updateData['temp_password_expires_at'] = now()->addDays(7);
        }
        // Manejar cambio de contraseña permanente
        elseif ($request->filled('password')) {
            $updateData['password'] = Hash::make($validated['password']);
            $updateData['is_temp_password'] = false;
            $updateData['temp_password_expires_at'] = null;
        }

        $user->update($updateData);

        $message = 'Usuario actualizado exitosamente.';

        // Si se generó contraseña temporal, mostrar modal
        if ($tempPassword) {
            return redirect()->route('admin.users.show', $user)
                ->with('success', $message)
                ->with('temp_password', $tempPassword)
                ->with('user_email', $user->email)
                ->with('show_password_modal', true);
        }

        return redirect()->route('admin.users.show', $user)
            ->with('success', $message);
    }

    // Importación masiva desde Excel/CSV
    public function showImportForm()
    {
        $this->authorize('create', User::class);

        return view('admin.users.import');
    }

    public function import(Request $request)
    {
        $this->authorize('create', User::class);

        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:10240',
        ]);

        try {
            $import = new UsersImport(auth()->id());
            Excel::import($import, $request->file('file'));

            $results = $import->getResults();

            // Si hay usuarios creados, guardar en sesión para mostrar en modal
            if (!empty($results['created_users'])) {
                session()->flash('import_results', $results);
                session()->flash('show_import_summary', true);
            }

            $message = "Importación completada: {$results['success_count']} usuarios creados exitosamente.";

            if ($results['error_count'] > 0) {
                $message .= " {$results['error_count']} filas con errores.";
            }

            return redirect()->route('admin.users.index')
                ->with('success', $message)
                ->with('import_errors', $results['errors']);
        } catch (\Exception $e) {
            return back()->with('error', 'Error al importar usuarios: ' . $e->getMessage());
        }
    }

    // Historial de descargas
    public function downloadHistory(User $user)
    {
        $this->authorize('view', $user);

        $query = UserDownload::where('user_id', $user->id)
            ->with('book')
            ->latest();

        // Aplicar filtros
        if (request('filter') == 'today') {
            $query->whereDate('downloaded_at', today());
        } elseif (request('filter') == 'week') {
            $query->where('downloaded_at', '>=', now()->subDays(7));
        }

        $downloads = $query->paginate(20);

        return view('admin.users.download-history', compact('user', 'downloads'));
    }

    // Historial de préstamos físicos
    public function loanHistory(User $user)
    {
        $this->authorize('view', $user);

        $query = BookLoan::where('user_id', $user->id)
            ->with(['physicalCopy.book', 'physicalCopy.book.details'])
            ->latest();

        // Aplicar filtros
        if (request('filter') == 'active') {
            $query->active();
        } elseif (request('filter') == 'overdue') {
            $query->overdue();
        } elseif (request('filter') == 'returned') {
            $query->returned();
        }

        $loans = $query->paginate(20);

        return view('admin.users.loan-history', compact('user', 'loans'));
    }

    // Historial de reservas
    public function reservationHistory(User $user)
    {
        $this->authorize('view', $user);

        $query = BookReservation::where('user_id', $user->id)
            ->with(['book', 'book.details'])
            ->latest();

        // Aplicar filtros
        if (request('filter') == 'active') {
            $query->active();
        } elseif (request('filter') == 'pending') {
            $query->pending();
        } elseif (request('filter') == 'expired') {
            $query->expired();
        }

        $reservations = $query->paginate(20);

        return view('admin.users.reservation-history', compact('user', 'reservations'));
    }

    // Activación/Desactivación
    public function toggleStatus(User $user)
    {
        $this->authorize('toggleStatus', $user);

        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'activada' : 'desactivada';
        return back()->with('success', "Cuenta {$status} exitosamente.");
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        // Verificar si es el último admin
        if ($user->isAdmin() && User::where('role', 'admin')->count() === 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'No puedes eliminar el único administrador del sistema.');
        }

        // Eliminar relaciones del sistema físico
        $user->bookReservations()->delete();
        $user->bookLoans()->delete();

        // Eliminar descargas relacionadas
        $user->downloads()->delete();

        // Eliminar órdenes y pagos relacionados
        $user->orders()->each(function ($order) {
            $order->orderDetails()->delete();
            $order->payment()->delete();
            $order->delete();
        });

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }

    public function downloadImportReport(Request $request)
    {
        $importResults = session('import_results');

        if (!$importResults || empty($importResults['created_users'])) {
            return redirect()->route('admin.users.index')
                ->with('error', 'No hay datos de importación disponibles.');
        }

        $csvContent = "Nombre,Email,DNI,Contraseña Temporal\n";

        foreach ($importResults['created_users'] as $user) {
            $csvContent .= "\"{$user['name']}\",\"{$user['email']}\",\"{$user['dni']}\",\"{$user['temp_password']}\"\n";
        }

        $filename = 'reporte_usuarios_importados_' . date('Y-m-d_H-i-s') . '.csv';

        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }

    public function clearImportSession(Request $request)
    {
        $request->session()->forget(['import_results', 'show_import_summary']);
        return response()->json(['success' => true]);
    }
}
