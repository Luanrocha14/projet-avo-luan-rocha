<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventoInscrito;

class EventoController extends Controller
{
    public function index()
    {
        // AGORA É PAGINADO
        $inscritos = EventoInscrito::orderBy('nome')->paginate(10);

        return view('evento.index', compact('inscritos'));
    }

    public function create()
    {
        return view('evento.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|min:3',
            'cpf'  => 'required|string|unique:evento_inscritos,cpf',
        ]);

        EventoInscrito::create([
            'nome' => $request->nome,
            'cpf'  => $request->cpf,
        ]);

        return redirect()
            ->route('evento.index')
            ->with('success', 'Inscrição realizada com sucesso!');
    }
}
