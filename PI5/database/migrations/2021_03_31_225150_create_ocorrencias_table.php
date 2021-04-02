<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOcorrenciasTable extends Migration
{
    public function up()
    {
        Schema::create('ocorrencias', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->integer('user_id')->references('id')->on('users');
            $table->integer('caso_id')->references('id')->on('casos');
            $table->integer('especialidade_id')->references('id')->on('especialidades');
            $table->string('tipo');
            $table->timestamp('data')->nullable();
            $table->text('medico');
            $table->text('crm');
            $table->text('receitas');
            $table->text('local');
            $table->text('desc');
            $table->text('resumo');
            $table->string('importancia');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ocorrencias');
    }
}
