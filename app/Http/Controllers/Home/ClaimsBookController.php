<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\Mail\ClaimMailRequest;
use App\Http\Controllers\Controller;
use App\Mail\ClaimMail;
use App\Models\Claims;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ClaimsBookController extends Controller
{
    public function index()
    {
        return view('claims-book');
    }

    public function store(ClaimMailRequest $request)
    {
        $data = $request->validated();

        // Guardar en la base de datos
        $claim = Claims::create($data);

        try {
            // Enviar email
            Mail::to('jcana@mattinnovasolution.com')
                ->cc($request->email)
                ->send(new ClaimMail($data));

            return back()->with('mensaje', 'Se envió su reclamo correctamente. Recibirá un email de confirmación.');
        } catch (\Exception $e) {
            // Log del error para debugging
            Log::error('Error enviando email de reclamo: ' . $e->getMessage());

            // Aún así retornar éxito porque el reclamo se guardó en la BD
            return back()->with('mensaje', 'Reclamo registrado correctamente. Nos pondremos en contacto pronto.');
        }
    }
}
