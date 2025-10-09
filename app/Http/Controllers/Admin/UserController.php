<?php
// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        $user->load(['orders' => function ($query) {
            $query->with(['orderDetails.book', 'payment'])->latest();
        }]);

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        // Agregar 'moderator' a los roles disponibles
        $roles = ['admin', 'moderator', 'user'];
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'institutional_email' => ['nullable', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:admin,moderator,user',
            'is_active' => 'boolean',
            'dni' => ['nullable', 'numeric', 'digits:8', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'numeric', 'digits:9', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    // NUEVO MÉTODO PARA ACTIVAR/DESACTIVAR USUARIOS
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
