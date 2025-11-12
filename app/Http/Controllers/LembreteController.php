<?php

namespace App\Http\Controllers;

use App\Models\Lembrete;
use Illuminate\Http\Request;

class LembreteController extends Controller
{
    /**
     * Exibe a lista de lembretes (pendentes e pagos)
     */
    public function index()
    {
        $lembretes = Lembrete::orderBy('data_vencimento')->paginate(5);
        return view('lembretes.index', compact('lembretes'));
    }

    /**
     * Exibe o formulário de criação
     */
    public function create()
    {
        return view('lembretes.create');
    }

    /**
     * Armazena um novo lembrete
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'valor' => 'required|numeric',
            'data_vencimento' => 'required|date',
        ]);

        Lembrete::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'data_vencimento' => $request->data_vencimento,
            'pago' => false,
        ]);

        return redirect()->route('lembretes.index')
            ->with('success', 'Lembrete criado com sucesso!');
    }

    /**
     * Exibe o formulário de edição
     */
    public function edit(Lembrete $lembrete)
    {
        return view('lembretes.edit', compact('lembrete'));
    }

    /**
     * Atualiza um lembrete existente
     */
    public function update(Request $request, Lembrete $lembrete)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'valor' => 'required|numeric',
            'data_vencimento' => 'required|date',
        ]);

        $lembrete->update([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'data_vencimento' => $request->data_vencimento,
        ]);

        return redirect()->route('lembretes.index')
            ->with('success', 'Lembrete atualizado com sucesso!');
    }

    /**
     * Remove um lembrete
     */
    public function destroy(Lembrete $lembrete)
    {
        $lembrete->delete();

        return redirect()->route('lembretes.index')
            ->with('success', 'Lembrete removido com sucesso!');
    }

    /**
     * Marca uma conta como paga
     */
    public function pagar($id)
    {
        $lembrete = Lembrete::findOrFail($id);

        $lembrete->update([
            'pago' => true,
            'data_pagamento' => now(),
        ]);

        return redirect()->route('lembretes.index')
            ->with('success', 'Conta marcada como paga com sucesso!');
    }

    /**
     * Exibe o histórico de contas pagas
     */
    public function pagos()
    {
        $pagos = Lembrete::where('pago', true)
            ->orderByDesc('data_pagamento')
            ->paginate(10);

        return view('lembretes.pagos', compact('pagos'));
    }
}
