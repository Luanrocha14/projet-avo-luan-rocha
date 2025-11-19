<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\ProdutoImagem; // 👈 IMPORTANTE
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
   public function index()
{
    $produtos = Produto::with('imagens')->orderBy('id', 'DESC')->paginate(10);

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
            'imagens.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        // 🔹 Calcula lucro
        $lucro = $request->preco_venda - $request->preco_custo;

        // 🔹 Cria o produto
        $produto = Produto::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco_custo' => $request->preco_custo,
            'preco_venda' => $request->preco_venda,
            'lucro' => $lucro,
        ]);

        // 🔹 Salva múltiplas imagens (se houver)
        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $imagem) {
                $caminho = $imagem->store('produtos', 'public');

                ProdutoImagem::create([
                    'produto_id' => $produto->id,
                    'caminho' => $caminho,
                ]);
            }
        }

        return redirect()
            ->route('produtos.index')
            ->with('success', '✅ Produto criado com sucesso!');
    }

    public function show(Produto $produto)
    {
        // 🔹 Exibe o produto com suas imagens
        $produto->load('imagens');

        return view('produtos.show', compact('produto'));
    }

    public function edit(Produto $produto)
    {
        $produto->load('imagens');
        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, Produto $produto)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco_custo' => 'required|numeric|min:0',
            'preco_venda' => 'required|numeric|min:0',
            'imagens.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        // 🔹 Atualiza informações do produto
        $lucro = $request->preco_venda - $request->preco_custo;

        $produto->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco_custo' => $request->preco_custo,
            'preco_venda' => $request->preco_venda,
            'lucro' => $lucro,
        ]);

        // 🔹 Adiciona novas imagens
        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $imagem) {
                $caminho = $imagem->store('produtos', 'public');

                ProdutoImagem::create([
                    'produto_id' => $produto->id,
                    'caminho' => $caminho,
                ]);
            }
        }

        return redirect()
            ->route('produtos.index')
            ->with('success', '✅ Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        // 🔹 Deleta imagens do produto
        foreach ($produto->imagens as $img) {
            if (Storage::disk('public')->exists($img->caminho)) {
                Storage::disk('public')->delete($img->caminho);
            }
            $img->delete();
        }

        // 🔹 Deleta o produto
        $produto->delete();

        return redirect()
            ->route('produtos.index')
            ->with('success', '🗑️ Produto removido com sucesso!');
    }

    public function album()
    {
        // 🔹 Lista com paginação
        $produtos = Produto::with('imagens')->orderByDesc('id')->paginate(6);

        return view('produtos.album', compact('produtos'));
    }
}
