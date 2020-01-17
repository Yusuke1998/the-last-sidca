<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthoritiesTable extends Migration
{
    public function up()
    {
        Schema::create('authorities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type',[
                'rector', #rector
                'vicerector academico', #vicerrector academico
                'vicerector administrativo', #vicerrector administrativo
                'secretario', #secretario
                'decano', #secretario
                'director', #secretario
                'other' #otro
            ])->default('other');

            $table->bigInteger('person_id')->unsigned(); #persona
            $table->foreign('person_id')
                ->references('id')
                ->on('people')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('authorities');
    }
}
