<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDownload;
use App\Models\BookLoan;
use App\Models\BookReservation;
use App\Services\UserService;
use App\Http\Requests\Admin\users\StoreUserRequest;
use App\Http\Requests\Admin\users\UpdateUserRequest;
use App\Http\Requests\Admin\users\ImportUsersRequest;
use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::with(['creator', 'activeLoans', 'pendingReservations'])->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);

        return view('admin.users.create', ['roles' => $this->getRoles()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        try {
            $result = $this->userService->createUser($request->validated(), auth()->id());

            return redirect()->route('admin.users.show', $result['user'])
                ->with('success', 'Usuario creado exitosamente.')
                ->with('temp_password', $result['temp_password'])
                ->with('user_email', $result['user']->email)
                ->with('show_password_modal', true);
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        $user->load($this->getUserRelations());

        return view('admin.users.show', [
            'user' => $user,
            'downloadStats' => $this->getDownloadStats($user),
            'physicalStats' => $this->getPhysicalStats($user)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('admin.users.edit', ['user' => $user, 'roles' => $this->getRoles()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        try {
            $result = $this->userService->updateUser($user, $request->validated());

            if (isset($result['temp_password'])) {
                return redirect()->route('admin.users.show', $user)
                    ->with('success', 'Usuario actualizado exitosamente.')
                    ->with('temp_password', $result['temp_password'])
                    ->with('user_email', $user->email)
                    ->with('show_password_modal', true);
            }

            return redirect()->route('admin.users.show', $user)
                ->with('success', 'Usuario actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        if ($this->isLastAdmin($user)) {
            return redirect()->route('admin.users.index')
                ->with('error', 'No puedes eliminar el único administrador del sistema.');
        }

        $this->userService->deleteUser($user);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }

    /**
     * Import users from Excel/CSV
     */
    public function showImportForm()
    {
        $this->authorize('create', User::class);

        return view('admin.users.import');
    }

    public function import(ImportUsersRequest $request)
    {
        $this->authorize('create', User::class);

        try {
            $import = new UsersImport(auth()->id());
            Excel::import($import, $request->file('file'));

            $results = $import->getResults();

            $this->storeImportResultsInSession($results);

            $message = $this->buildImportMessage($results);

            return redirect()->route('admin.users.index')
                ->with('success', $message)
                ->with('import_errors', $results['errors'] ?? []);
        } catch (\Exception $e) {
            return back()->with('error', 'Error al importar usuarios: ' . $e->getMessage());
        }
    }

    /**
     * History methods
     */
    public function downloadHistory(User $user)
    {
        $this->authorize('view', $user);

        $downloads = UserDownload::where('user_id', $user->id)->with('book')->filtered()->latest()->paginate(20);

        return view('admin.users.download-history', compact('user', 'downloads'));
    }

    public function loanHistory(User $user)
    {
        $this->authorize('view', $user);

        $loans = BookLoan::where('user_id', $user->id)
            ->with(['physicalCopy.book', 'physicalCopy.book.details'])->filtered()->latest()->paginate(20);

        return view('admin.users.loan-history', compact('user', 'loans'));
    }

    public function reservationHistory(User $user)
    {
        $this->authorize('view', $user);

        $reservations = BookReservation::where('user_id', $user->id)
            ->with(['book', 'book.details'])
            ->filtered()
            ->latest()
            ->paginate(20);

        return view('admin.users.reservation-history', compact('user', 'reservations'));
    }

    /**
     * Toggle user status
     */
    public function toggleStatus(User $user)
    {
        $this->authorize('toggleStatus', $user);

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activada' : 'desactivada';
        return back()->with('success', "Cuenta {$status} exitosamente.");
    }

    /**
     * Download import report
     */
    public function downloadImportReport(Request $request)
    {
        $importResults = session('import_results');

        if (!$importResults || empty($importResults['created_users'])) {
            return redirect()->route('admin.users.index')
                ->with('error', 'No hay datos de importación disponibles.');
        }

        return $this->generateImportReportCsv($importResults['created_users']);
    }

    /**
     * Clear session data
     */
    public function clearTempPassword(Request $request)
    {
        $request->session()->forget(['temp_password', 'user_email', 'show_password_modal']);
        return response()->json(['success' => true]);
    }

    public function clearImportSession(Request $request)
    {
        $request->session()->forget(['import_results', 'show_import_summary']);
        return response()->json(['success' => true]);
    }

    /**
     * Private helper methods
     */
    private function getRoles(): array
    {
        return ['admin' => 'Administrador', 'librarian' => 'Bibliotecario', 'user' => 'Usuario Normal'];
    }

    private function getUserRelations(): array
    {
        return [
            'creator',
            'orders' => function ($query) {
                $query->with(['orderDetails.book', 'payment'])->latest();
            },
            'downloads' => function ($query) {
                $query->with('book')->latest()->take(10);
            },
            'activeLoans' => function ($query) {
                $query->with(['physicalCopy.book', 'physicalCopy.book.details'])->latest();
            },
            'pendingReservations' => function ($query) {
                $query->with(['book', 'book.details'])->latest();
            },
            'bookLoans' => function ($query) {
                $query->with(['physicalCopy.book'])->latest()->take(5);
            }
        ];
    }

    private function getDownloadStats(User $user): array
    {
        return [
            'today' => $user->downloads()->whereDate('downloaded_at', today())->count(),
            'total' => $user->downloads()->count(),
            'remaining' => max(0, 5 - $user->downloads_today)
        ];
    }

    private function getPhysicalStats(User $user): array
    {
        return [
            'active_loans' => $user->activeLoans()->count(),
            'overdue_loans' => $user->bookLoans()->overdue()->count(),
            'pending_reservations' => $user->pendingReservations()->count(),
            'total_loans' => $user->bookLoans()->count(),
        ];
    }

    private function isLastAdmin(User $user): bool
    {
        return $user->isAdmin() && User::where('role', 'admin')->count() === 1;
    }

    private function storeImportResultsInSession(array $results): void
    {
        if (!empty($results['created_users'])) {
            session()->flash('import_results', $results);
            session()->flash('show_import_summary', true);
        }
    }

    private function buildImportMessage(array $results): string
    {
        $message = "Importación completada: {$results['success_count']} usuarios creados exitosamente.";

        if ($results['error_count'] > 0) {
            $message .= " {$results['error_count']} filas con errores.";
        }

        return $message;
    }

    private function generateImportReportCsv(array $createdUsers)
    {
        $csvContent = "Nombre,Email,DNI,Contraseña Temporal\n";

        foreach ($createdUsers as $user) {
            $csvContent .= "\"{$user['name']}\",\"{$user['email']}\",\"{$user['dni']}\",\"{$user['temp_password']}\"\n";
        }

        $filename = 'reporte_usuarios_importados_' . date('Y-m-d_H-i-s') . '.csv';

        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }
}
