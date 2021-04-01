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
            $table->string('tipo')->default('C');
            $table->timestamp('data')->nullable();
            $table->text('medico')->default('');
            $table->text('crm')->default('');
            $table->text('receitas')->default('');
            $table->text('local')->default('');
            $table->text('desc')->default('');
            $table->text('resumo')->default('');
            $table->string('importancia')->default('R');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ocorrencias');
    }
}
