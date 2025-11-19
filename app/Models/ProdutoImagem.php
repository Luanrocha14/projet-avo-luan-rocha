<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoImagem extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'produto_imagens';

    // Campos permitidos para preenchimento
    protected $fillable = [
        'produto_id',
        'caminho',
        'carousel',
    ];

    /**
     * Relação com Produto
     * Cada imagem pertence a um produto
     */
    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
