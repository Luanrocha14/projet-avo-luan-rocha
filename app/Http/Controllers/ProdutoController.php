<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::orderByDesc('id')->paginate(5);
        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request)
    {
        // 🔹 Validação
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco_custo' => 'required|numeric|min:0',
            'preco_venda' => 'required|numeric|min:0',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 🔹 Calcula o lucro automaticamente
        $lucro = $request->preco_venda - $request->preco_custo;

        // 🔹 Salva a imagem (se houver)
        $caminhoImagem = null;
        if ($request->hasFile('imagem')) {
            $caminhoImagem = $request->file('imagem')->store('produtos', 'public');
        }

        // 🔹 Cria o produto no banco
        Produto::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco_custo' => $request->preco_custo,
            'preco_venda' => $request->preco_venda,
            'lucro' => $lucro,
            'imagem' => $caminhoImagem,
        ]);

        return redirect()->route('produtos.index')->with('success', '✅ Produto adicionado com sucesso!');
    }

    public function show(Produto $produto)
    {
        // 🔹 Exibe detalhes do produto (rota: produtos.show)
        return view('produtos.show', compact('produto'));
    }

    public function edit(Produto $produto)
    {
        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, Produto $produto)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco_custo' => 'required|numeric|min:0',
            'preco_venda' => 'required|numeric|min:0',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $lucro = $request->preco_venda - $request->preco_custo;

        $dados = $request->only(['nome', 'descricao', 'preco_custo', 'preco_venda']);
        $dados['lucro'] = $lucro;

        // 🔹 Se houver nova imagem, remove a antiga e salva a nova
        if ($request->hasFile('imagem')) {
            if ($produto->imagem && Storage::disk('public')->exists($produto->imagem)) {
                Storage::disk('public')->delete($produto->imagem);
            }
            $dados['imagem'] = $request->file('imagem')->store('produtos', 'public');
        }

        $produto->update($dados);

        return redirect()->route('produtos.index')->with('success', '✅ Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        if ($produto->imagem && Storage::disk('public')->exists($produto->imagem)) {
            Storage::disk('public')->delete($produto->imagem);
        }

        $produto->delete();

        return redirect()->route('produtos.index')->with('success', '🗑️ Produto removido com sucesso!');
    }

    public function album()
    {
        // 🔹 Exibe os produtos em forma de catálogo com paginação
        $produtos = Produto::orderByDesc('id')->paginate(6);
        return view('produtos.album', compact('produtos'));
    }
}
