<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoInscrito extends Model
{
    protected $table = 'evento_inscritos';

    protected $fillable = ['nome', 'cpf'];
}
