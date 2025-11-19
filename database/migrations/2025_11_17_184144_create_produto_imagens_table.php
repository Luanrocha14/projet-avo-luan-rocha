<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produto_imagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')->constrained()->onDelete('cascade');
            $table->string('caminho');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produto_imagens');
    }
};
