<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutoImagensTable extends Migration
{
    public function up()
    {
        Schema::create('produto_imagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
            $table->string('caminho'); // caminho dentro do disk public (ex: produtos/arquivo.jpg)
            $table->boolean('carousel')->default(false); // marcar se aparece no carrossel
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produto_imagens');
    }
}
