<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareerSubjectTable extends Migration
{
    public function up()
    {
        Schema::create('career_subject', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('career_id')->unsigned(); #carrera
            $table->foreign('career_id')
                    ->references('id')
                    ->on('careers')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->bigInteger('subject_id')->unsigned(); #asignatura
            $table->foreign('subject_id')
                    ->references('id')
                    ->on('subjects')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('career_subject');
    }
}