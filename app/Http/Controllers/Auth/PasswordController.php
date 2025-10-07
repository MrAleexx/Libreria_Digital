<?php

namespace App\Http\Controllers\Auth;

use App\Mail\PasswordMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Auth\PasswordRequest;

class PasswordController extends Controller
{
    public function index()
    {
        return view('auth.password');
    }

    public function store(PasswordRequest $request)
    {
        $data = $request->validated();

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $data['email']],
            [
                'email' => $data['email'],
                'token' => $token,
                'created_at' => now(),
            ]
        );

        Mail::to($data['email'])->send(new PasswordMail([
            'email' => $data['email'],
            'token' => $token,
        ]));

        return back()->with('mensaje', 'Se envió un mensaje a su correo');
    }
}
