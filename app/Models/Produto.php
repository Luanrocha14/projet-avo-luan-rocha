<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'preco_custo',
        'preco_venda',
        'lucro',
        'imagem',
    ];

    // ✔ RELAÇÃO CORRETA (informando o campo produto_id)
    public function imagens()
    {
    return $this->hasMany(ProdutoImagem::class);
    }
}
