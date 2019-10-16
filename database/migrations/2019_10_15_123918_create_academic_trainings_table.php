<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicTrainingsTable extends Migration
{
    public function up()
    {
        Schema::create('academic_trainings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type',['curso','taller','conferencia']); #tipos
            $table->text('description'); #descripcion
            $table->date('start')->nullable(); #inicio
            $table->date('end')->nullable(); #fin
            $table->integer('hours')->nullable(); #horas

            $table->bigInteger('teacher_id')->unsigned(); #profesor
            $table->foreign('teacher_id')
                    ->references('id')
                    ->on('teachers')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                    
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('academic_trainings');
    }
}
