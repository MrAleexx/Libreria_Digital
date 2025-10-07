<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('user.update');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'      => ['nullable', 'max:60', 'string'],
            'last_name' => ['nullable', 'max:60', 'string'],
            'dni'       => ['nullable', 'numeric', 'digits:8'],
            'phone'     => ['nullable', 'numeric', 'digits:9'],
            'email'     => ['nullable', 'email', 'unique:users,email,' . $user->id],
        ]);

        $data = array_filter($data, fn($value) => !is_null($value));

        $user->update($data);

        return back()->with('mensaje', 'Perfil actualizado correctamente');
    }
}
