<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiposTable extends Migration
{
    public function up()
    {
        Schema::create('tipos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipos');
    }
}
