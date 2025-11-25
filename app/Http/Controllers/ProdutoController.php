<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\ProdutoImagem;
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
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco_custo' => 'required|numeric|min:0',
            'preco_venda' => 'required|numeric|min:0',
            'imagens.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $lucro = $request->preco_venda - $request->preco_custo;

        $produto = Produto::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco_custo' => $request->preco_custo,
            'preco_venda' => $request->preco_venda,
            'lucro' => $lucro,
        ]);

        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $img) {
                $caminho = $img->store('produtos', 'public');

                ProdutoImagem::create([
                    'produto_id' => $produto->id,
                    'caminho' => $caminho,
                    'carousel' => false,
                ]);
            }
        }

        return redirect()->route('produtos.index')
            ->with('success', '✅ Produto criado com sucesso!');
    }

    public function show(Produto $produto)
    {
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
            'imagens.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'apagar_imagens.*' => 'nullable|integer|exists:produto_imagens,id',
            'carousel_imagens.*' => 'nullable|integer|exists:produto_imagens,id',
        ]);

        $lucro = $request->preco_venda - $request->preco_custo;

        $produto->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco_custo' => $request->preco_custo,
            'preco_venda' => $request->preco_venda,
            'lucro' => $lucro,
        ]);

        // REMOVER IMAGENS MARCADAS
        if ($request->filled('apagar_imagens')) {
            foreach ($request->apagar_imagens as $idImg) {
                $img = ProdutoImagem::find($idImg);
                if ($img && $img->produto_id === $produto->id) {
                    if (Storage::disk('public')->exists($img->caminho)) {
                        Storage::disk('public')->delete($img->caminho);
                    }
                    $img->delete();
                }
            }
        }

        // RESETAR campo carousel para todas as imagens deste produto
        foreach ($produto->imagens as $img) {
            $img->carousel = false;
            $img->save();
        }

        // ATIVAR CARROSSEL NAS IMAGENS SELECIONADAS
        if ($request->filled('carousel_imagens')) {
            foreach ($request->carousel_imagens as $idImg) {
                $img = ProdutoImagem::where('produto_id', $produto->id)->where('id', $idImg)->first();
                if ($img) {
                    $img->carousel = true;
                    $img->save();
                }
            }
        }

        // ADICIONAR NOVAS IMAGENS
        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $imgFile) {
                $caminho = $imgFile->store('produtos', 'public');

                ProdutoImagem::create([
                    'produto_id' => $produto->id,
                    'caminho' => $caminho,
                    'carousel' => false,
                ]);
            }
        }

        return redirect()->route('produtos.index')
            ->with('success', '✅ Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        foreach ($produto->imagens as $img) {
            if (Storage::disk('public')->exists($img->caminho)) {
                Storage::disk('public')->delete($img->caminho);
            }
            $img->delete();
        }

        $produto->delete();

        return redirect()->route('produtos.index')
            ->with('success', '🗑️ Produto removido com sucesso!');
    }

    public function album()
    {
        $produtos = Produto::with('imagens')->orderByDesc('id')->paginate(12);
        return view('produtos.album', compact('produtos'));
    }
}
