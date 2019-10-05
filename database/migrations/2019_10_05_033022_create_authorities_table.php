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
                'academic_vice_chancellor', #vicerrector academico
                'administrative_vice_chancellor', #vicerrector administrativo
                'secretary', #secretario
                'other' #otro
            ])->default('other');

            $table->bigInteger('person_id')->unsigned(); #persona
            $table->foreign('person_id')
                ->references('id')
                ->on('people')
                ->ondDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('authorities');
    }
}