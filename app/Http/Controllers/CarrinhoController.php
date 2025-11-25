<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class CarrinhoController extends Controller
{
    public function index()
    {
        $carrinho = session()->get('carrinho', []);
        return view('carrinho.index', compact('carrinho'));
    }

    public function adicionar($id)
    {
        $produto = Produto::with('imagens')->findOrFail($id);

        // Agora garantimos que a imagem vem correta
        $imagemPrincipal = optional($produto->imagens->first())->caminho;

        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$id])) {
            $carrinho[$id]['quantidade']++;
        } else {
            $carrinho[$id] = [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'preco' => $produto->preco_venda,
                'imagem' => $imagemPrincipal, // ← AQUI VAI O CAMINHO CERTO
                'quantidade' => 1
            ];
        }

        session()->put('carrinho', $carrinho);

        return redirect()->route('carrinho.index')
            ->with('success', 'Produto adicionado ao carrinho!');
    }

    public function remover($id)
    {
        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$id])) {
            unset($carrinho[$id]);
            session()->put('carrinho', $carrinho);
        }

        return redirect()->route('carrinho.index')
            ->with('success', 'Item removido com sucesso.');
    }
}
