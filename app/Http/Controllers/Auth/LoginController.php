<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $data = $request->validated();

        if(!Auth::attempt($request->only('email', 'password'))) {
            return back()->with('mensaje', 'Credenciales Incorrectas');
        }

        return redirect()->route('perfil', Auth::user()->name);
    }
}
