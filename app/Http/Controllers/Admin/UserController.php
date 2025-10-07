<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // ✅ Verificar si puede ver cualquier usuario
        $this->authorize('viewAny', User::class);
        
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        // ✅ Verificar si puede ver este usuario
        $this->authorize('view', $user);
        
        $user->load(['orders' => function($query) {
            $query->with(['orderDetails.book', 'payment'])->latest();
        }]);
        
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        // ✅ Verificar si puede editar este usuario
        $this->authorize('update', $user);
        
        $roles = ['admin', 'user'];
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // ✅ Verificar si puede actualizar este usuario
        $this->authorize('update', $user);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
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

        
    public function destroy(User $user)
    {
        // ✅ Verificar si puede eliminar este usuario
        $this->authorize('delete', $user);
        
            // Prevenir que un usuario se elimine a sí mismo
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        // Eliminar órdenes y detalles relacionados antes de eliminar el usuario
        $user->orders()->each(function($order) {
            $order->orderDetails()->delete();
            $order->payment()->delete();
            $order->delete();
        });

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}