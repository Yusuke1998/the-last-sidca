<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerritorialClassroomsTable extends Migration
{
    public function up()
    {
        Schema::create('territorial_classrooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');

            $table->bigInteger('headquarter_id')->unsigned(); #sede
            $table->foreign('headquarter_id')
                ->references('id')
                ->on('headquarters')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->bigInteger('area_id')->unsigned(); #area
            $table->foreign('area_id')
                ->references('id')
                ->on('areas')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->bigInteger('program_id')->unsigned(); #programa
            $table->foreign('program_id')
                ->references('id')
                ->on('programs')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('territorial_classrooms');
    }
}
