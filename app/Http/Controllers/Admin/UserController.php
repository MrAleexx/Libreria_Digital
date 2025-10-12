<?php
// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDownload;
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

        $users = User::with('creator')
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
            }
        ]);

        // Estadísticas de descargas
        $downloadStats = [
            'today' => $user->downloads()->today()->count(),
            'total' => $user->downloads()->count(),
            'remaining' => max(0, 5 - $user->downloads_today)
        ];

        return view('admin.users.show', compact('user', 'downloadStats'));
    }

    // NUEVO MÉTODO: Crear usuario individual
    public function create()
    {
        $this->authorize('create', User::class);

        $roles = ['admin', 'moderator', 'user'];
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
            'role' => 'required|in:admin,moderator,user',
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
            'institutional_email' => $validated['institutional_email'],
            'dni' => $validated['dni'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'password' => Hash::make($tempPassword),
            'is_temp_password' => true,
            'temp_password_expires_at' => now()->addDays(7),
            'created_by' => auth()->id(),
        ];

        $user = User::create($userData);

        // TODO: Enviar email con credenciales si send_credentials es true
        if ($request->boolean('send_credentials')) {
            // Mail::to($user->email)->send(new UserCredentialsMail($user, $tempPassword));
        }

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Usuario creado exitosamente.')
            ->with('temp_password', $tempPassword); // Mostrar contraseña temporal
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $roles = ['admin', 'moderator', 'user'];
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
            'role' => 'required|in:admin,moderator,user',
            'is_active' => 'boolean',
            'dni' => ['required', 'numeric', 'digits:8', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'numeric', 'digits:9', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'reset_temp_password' => 'boolean', // Nueva opción
        ]);

        // Si se solicita reset de contraseña temporal
        if ($request->boolean('reset_temp_password')) {
            $tempPassword = Str::random(10);
            $validated['password'] = Hash::make($tempPassword);
            $validated['is_temp_password'] = true;
            $validated['temp_password_expires_at'] = now()->addDays(7);

            // TODO: Enviar email con nueva contraseña
            // Mail::to($user->email)->send(new PasswordResetMail($tempPassword));
        } elseif ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
            $validated['is_temp_password'] = false;
            $validated['temp_password_expires_at'] = null;
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        $message = 'Usuario actualizado exitosamente.';
        if (isset($tempPassword)) {
            $message .= " Nueva contraseña temporal: $tempPassword";
        }

        return redirect()->route('admin.users.show', $user)
            ->with('success', $message);
    }

    // NUEVO MÉTODO: Importación masiva desde Excel/CSV
    public function showImportForm()
    {
        $this->authorize('create', User::class);

        return view('admin.users.import');
    }

    public function import(Request $request)
    {
        $this->authorize('create', User::class);

        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:10240', // 10MB max
        ]);

        try {
            Excel::import(new UsersImport(auth()->id()), $request->file('file'));

            return redirect()->route('admin.users.index')
                ->with('success', 'Usuarios importados exitosamente.');
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

        // Eliminar descargas relacionadas
        $user->downloads()->delete();

        $user->orders()->each(function ($order) {
            $order->orderDetails()->delete();
            $order->payment()->delete();
            $order->delete();
        });

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}
