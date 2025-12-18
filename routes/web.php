<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LembreteController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\EventoController;

/*
|--------------------------------------------------------------------------
| Rotas de Usuários
|--------------------------------------------------------------------------
*/

Route::get('/', [UserController::class, 'index'])->name('user.index');
Route::get('/show-user/{user}', [UserController::class, 'show'])->name('user.show');
Route::get('/create-user', [UserController::class, 'create'])->name('user.create');
Route::post('/store-user', [UserController::class, 'store'])->name('user.store');
Route::get('/edit-user/{user}', [UserController::class, 'edit'])->name('user.edit');
Route::put('/update-user/{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('/destroy-user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

/*
|--------------------------------------------------------------------------
| Rotas de Lembretes
|--------------------------------------------------------------------------
*/

// Listar
Route::get('/lembretes', [LembreteController::class, 'index'])->name('lembretes.index');

// Criar
Route::get('/lembretes/create', [LembreteController::class, 'create'])->name('lembretes.create');
Route::post('/lembretes', [LembreteController::class, 'store'])->name('lembretes.store');

// Editar
Route::get('/lembretes/{lembrete}/edit', [LembreteController::class, 'edit'])->name('lembretes.edit');
Route::put('/lembretes/{lembrete}', [LembreteController::class, 'update'])->name('lembretes.update');

// Excluir
Route::delete('/lembretes/{lembrete}', [LembreteController::class, 'destroy'])->name('lembretes.destroy');

// Pagar
Route::put('/lembretes/{id}/pagar', [LembreteController::class, 'pagar'])->name('lembretes.pagar');

// Histórico (antes era pagos — renomeado)
Route::get('/lembretes/historico', [LembreteController::class, 'pagos'])->name('lembretes.historico');

/*
|--------------------------------------------------------------------------
| Rotas de Produtos
|--------------------------------------------------------------------------
*/

// Listagem principal
Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');

// Criar
Route::get('/produtos/create', [ProdutoController::class, 'create'])->name('produtos.create');

// Salvar
Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');

// *** Catálogo em grade (álbum) – importante ficar ANTES da rota dinâmica ***
Route::get('/produtos/album', [ProdutoController::class, 'album'])->name('produtos.album');

// Visualizar item
Route::get('/produtos/{produto}', [ProdutoController::class, 'show'])->name('produtos.show');

// Editar
Route::get('/produtos/{produto}/edit', [ProdutoController::class, 'edit'])->name('produtos.edit');

// Atualizar
Route::put('/produtos/{produto}', [ProdutoController::class, 'update'])->name('produtos.update');

// Excluir
Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');

/*
|--------------------------------------------------------------------------
| Rotas do Carrinho
|--------------------------------------------------------------------------
*/
Route::get('/carrinho', [CarrinhoController::class, 'index'])->name('carrinho.index');
Route::get('/carrinho/adicionar/{id}', [CarrinhoController::class, 'adicionar'])->name('carrinho.adicionar');
Route::get('/carrinho/remover/{id}', [CarrinhoController::class, 'remover'])->name('carrinho.remover');

Route::get('jogo-rainhas', function () { return view('/rainhas');})->name('jogo.rainhas');

/*
|--------------------------------------------------------------------------
| Rotas do Evento
|--------------------------------------------------------------------------
*/

// Listar inscrições no evento
Route::get('/evento', [EventoController::class, 'index'])->name('evento.index');

// Criar inscrição
Route::get('/evento/cadastro', [EventoController::class, 'create'])->name('evento.create');
Route::post('/evento/cadastro', [EventoController::class, 'store'])->name('evento.store');

