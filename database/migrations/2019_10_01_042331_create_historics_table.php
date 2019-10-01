<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricsTable extends Migration
{
    public function up()
    {
        Schema::create('historics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_start'); #fecha inicio
            $table->date('date_end'); #fecha fin
            $table->string('workload'); #carga horaria
            $table->string('condition'); #condicion
            $table->string('category'); #categoria
            $table->string('dedication'); #decacion
            $table->string('request'); #solicitud
            $table->string('academic'); #academico
            $table->string('approval'); #aprobaion
            $table->text('observations')->nullable(); #observaciones

            // Relaciones
            $table->bigInteger('teacher_id')->unsigned(); #profesor
            $table->foreign('teacher_id')
                ->references('id')
                ->on('teachers')
                ->ondDelete('cascade')
                ->onUpdate('cascade');

            $table->bigInteger('movement_id')->unsigned(); #movimiento
            $table->foreign('movement_id')
                ->references('id')
                ->on('movements')
                ->ondDelete('cascade')
                ->onUpdate('cascade');

            $table->bigInteger('headquarter_id')->unsigned(); #sede
            $table->foreign('headquarter_id')
                ->references('id')
                ->on('headquarters')
                ->ondDelete('cascade')
                ->onUpdate('cascade');

            $table->bigInteger('core_id')->unsigned(); #nucleo
            $table->foreign('core_id')
                ->references('id')
                ->on('cores')
                ->ondDelete('cascade')
                ->onUpdate('cascade');

            $table->bigInteger('area_id')->unsigned(); #area
            $table->foreign('area_id')
                ->references('id')
                ->on('areas')
                ->ondDelete('cascade')
                ->onUpdate('cascade');

            $table->bigInteger('career_id')->unsigned(); #carrera
            $table->foreign('career_id')
                ->references('id')
                ->on('careers')
                ->ondDelete('cascade')
                ->onUpdate('cascade');

            $table->bigInteger('program_id')->unsigned(); #programa
            $table->foreign('program_id')
                ->references('id')
                ->on('programs')
                ->ondDelete('cascade')
                ->onUpdate('cascade');

            $table->bigInteger('period_id')->unsigned(); #periodo
            $table->foreign('period_id')
                ->references('id')
                ->on('periods')
                ->ondDelete('cascade')
                ->onUpdate('cascade');

            $table->bigInteger('subject_id')->unsigned(); #asignatura
            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects')
                ->ondDelete('cascade')
                ->onUpdate('cascade');
                
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historics');
    }
}
