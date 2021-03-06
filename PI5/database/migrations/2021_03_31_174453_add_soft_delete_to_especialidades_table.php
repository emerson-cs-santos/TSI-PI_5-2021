<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeleteToEspecialidadesTable extends Migration
{
    public function up()
    {
        Schema::table('especialidades', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('especialidades', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
