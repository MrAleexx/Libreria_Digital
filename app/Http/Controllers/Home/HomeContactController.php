<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\Mail\ContactMailRequest;
use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Contacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(ContactMailRequest $request)
    {
        $data = $request->validated();

        Contacts::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message
        ]);

        Mail::to('jcana@mattinnovasolution.com')
            ->cc($request->email)
            ->send(new ContactMail($data));

        return back()->with('mensaje', 'Mensaje enviado correctamente');
    }
}
