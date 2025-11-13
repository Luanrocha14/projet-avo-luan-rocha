<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LembreteController;
use App\Http\Controllers\ProdutoController;

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

// Listar todos os lembretes
Route::get('/lembretes', [LembreteController::class, 'index'])->name('lembretes.index');

// Criar novo lembrete
Route::get('/lembretes/create', [LembreteController::class, 'create'])->name('lembretes.create');
Route::post('/lembretes', [LembreteController::class, 'store'])->name('lembretes.store');

// Editar lembrete
Route::get('/lembretes/{lembrete}/edit', [LembreteController::class, 'edit'])->name('lembretes.edit');
Route::put('/lembretes/{lembrete}', [LembreteController::class, 'update'])->name('lembretes.update');

// Excluir lembrete
Route::delete('/lembretes/{lembrete}', [LembreteController::class, 'destroy'])->name('lembretes.destroy');

// Marcar lembrete como pago
Route::put('/lembretes/{id}/pagar', [LembreteController::class, 'pagar'])->name('lembretes.pagar');

// Página de histórico de pagos
Route::get('/pagos', [LembreteController::class, 'pagos'])->name('lembretes.pagos');

/*
|--------------------------------------------------------------------------
| Rotas de Produtos
|--------------------------------------------------------------------------
*/

// Página principal de produtos
Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');

// Formulário de criação
Route::get('/produtos/create', [ProdutoController::class, 'create'])->name('produtos.create');

// Salvar novo produto
Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');

// ⚠️ Colocada antes da rota dinâmica
Route::get('/produtos/album', [ProdutoController::class, 'album'])->name('produtos.album');

// Exibir produto específico
Route::get('/produtos/{produto}', [ProdutoController::class, 'show'])->name('produtos.show');

// Formulário de edição
Route::get('/produtos/{produto}/edit', [ProdutoController::class, 'edit'])->name('produtos.edit');

// Atualizar produto
Route::put('/produtos/{produto}', [ProdutoController::class, 'update'])->name('produtos.update');

// Excluir produto
Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');
