<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');

            // trabajo
            $table->string('title');
            $table->string('date');
            $table->string('url')->nullable();
            $table->string('file')->nullable();

            // jurado
            $table->string('coordinator');
            $table->string('principal1');
            $table->string('principal2');
            $table->string('alternate1');
            $table->string('alternate2');
            $table->string('alternate3');

            // presentacion
            $table->string('location');
            $table->date('datep');
            $table->date('hourp');

            $table->bigInteger('ascent_id')->unsigned(); #acenso
            $table->foreign('ascent_id')
                ->references('id')
                ->on('ascents')
                ->ondDelete('cascade')
                ->onUpdate('cascade');

            $table->bigInteger('teacher_id')->unsigned(); #docente
            $table->foreign('teacher_id')
                ->references('id')
                ->on('teachers')
                ->ondDelete('cascade')
                ->onUpdate('cascade');
                
            $table->bigInteger('postgraduate_id')->unsigned(); #postgrado
            $table->foreign('postgraduate_id')
                ->references('id')
                ->on('postgraduates')
                ->ondDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
