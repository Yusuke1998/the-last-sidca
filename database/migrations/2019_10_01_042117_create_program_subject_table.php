<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramSubjectTable extends Migration
{
    public function up()
    {
        Schema::create('program_subject', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('program_id')->unsigned(); #programa
            $table->foreign('program_id')
                    ->references('id')
                    ->on('programs')
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
        Schema::dropIfExists('program_subject');
    }
}
