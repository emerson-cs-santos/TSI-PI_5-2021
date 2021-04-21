<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArquivosTable extends Migration
{
    public function up()
    {
        Schema::create('arquivos', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->references('id')->on('users');
            $table->integer('caso_id')->references('id')->on('casos');
            $table->integer('ocorrencia_id')->references('id')->on('ocorrencias');
            $table->text('nome');
            $table->string('extensao');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('arquivos');
    }
}
