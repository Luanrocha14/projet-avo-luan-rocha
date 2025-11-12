<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembrete extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao',
        'valor',
        'data_vencimento',
        'pago',
    ];
}
