<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasosTable extends Migration
{
    public function up()
    {
        Schema::create('casos', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->integer('user_id')->references('id')->on('users');
            $table->text('nome');
            $table->text('desc');
            $table->string('status');
            $table->text('medicamentos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('casos');
    }
}
