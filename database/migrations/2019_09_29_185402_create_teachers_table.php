<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration
{
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('contract',['contratado','ordinario']); #contrato
            $table->bigInteger('person_id')->unsigned(); #persona
            $table->bigInteger('headquarter_id')->unsigned(); #sede
            $table->bigInteger('area_id')->unsigned(); #area
            $table->bigInteger('program_id')->unsigned(); #programa
            $table->bigInteger('core_id')->unsigned()->nullable(); #nucleo
            $table->bigInteger('extension_id')->unsigned()->nullable(); #extension
            $table->bigInteger('territorial_classroom_id')->unsigned()->nullable(); #aula territorial
            $table->bigInteger('condition_id')->unsigned()->nullable(); #condicion

            $table->foreign('person_id')
                ->references('id')
                ->on('people')
                ->ondDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('headquarter_id')
                ->references('id')
                ->on('headquarters')
                ->ondDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('area_id')
                ->references('id')
                ->on('areas')
                ->ondDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('program_id')
                ->references('id')
                ->on('programs')
                ->ondDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('core_id')
                ->references('id')
                ->on('cores')
                ->ondDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('extension_id')
                ->references('id')
                ->on('extensions')
                ->ondDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('territorial_classroom_id')
                ->references('id')
                ->on('territorial_classrooms')
                ->ondDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('condition_id')
                ->references('id')
                ->on('conditions')
                ->ondDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teachers');
    }
}
