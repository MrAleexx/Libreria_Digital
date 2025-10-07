<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Claims;
use Illuminate\Http\Request;

class ClaimsController extends Controller
{
    public function index()
    {
        return view('admin.claims.index');
    }

    public function show(Claims $claim)
    {
        $tipos = [
            'problema_descarga' => 'Problema con la descarga',
            'cobro_indebido' => 'Cobro indebido',
            'acceso_cuenta' => 'Problema de acceso',
            'otro' => 'Otro'
        ];

        return view('admin.claims.show', compact('claim', 'tipos'));
    }

    public function destroy(Claims $claim)
    {
        $claim->delete();

        return redirect()->route('admin.claims.index')
            ->with('success', 'Reclamo eliminado correctamente');
    }
}
