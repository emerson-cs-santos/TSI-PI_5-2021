<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTipoFromOcorrenciasTable extends Migration
{
    public function up()
    {
        Schema::table('ocorrencias', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }

    public function down()
    {
        Schema::table('ocorrencias', function (Blueprint $table) {
            $table->string('tipo');
        });
    }
}
