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
            
            $table->enum('status',['activo','inactivo'])->default('activo'); #estatus
            $table->bigInteger('person_id')->unsigned(); #persona
            $table->bigInteger('headquarter_id')->unsigned(); #sede
            $table->bigInteger('area_id')->unsigned(); #area
            $table->bigInteger('program_id')->unsigned(); #programa
            $table->bigInteger('core_id')->unsigned()->nullable(); #nucleo
            $table->bigInteger('extension_id')->unsigned()->nullable(); #extension
            $table->bigInteger('territorial_classroom_id')->unsigned()->nullable(); #aula territorial
            $table->bigInteger('condition_id')->unsigned()->nullable(); #condicion
            $table->bigInteger('category_id')->unsigned()->nullable(); #categoria
            $table->bigInteger('dedication_id')->unsigned()->nullable(); #dedicacion

            $table->foreign('person_id')
                ->references('id')
                ->on('people')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('headquarter_id')
                ->references('id')
                ->on('headquarters')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('area_id')
                ->references('id')
                ->on('areas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('program_id')
                ->references('id')
                ->on('programs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('core_id')
                ->references('id')
                ->on('cores')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('extension_id')
                ->references('id')
                ->on('extensions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('territorial_classroom_id')
                ->references('id')
                ->on('territorial_classrooms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('condition_id')
                ->references('id')
                ->on('conditions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('dedication_id')
                ->references('id')
                ->on('dedications')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teachers');
    }
}
