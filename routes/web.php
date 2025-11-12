<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LembreteController;

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
