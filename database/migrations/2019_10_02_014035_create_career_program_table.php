<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareerProgramTable extends Migration
{
    public function up()
    {
        Schema::create('career_program', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('career_id')->unsigned(); #carrera
            $table->foreign('career_id')
                    ->references('id')
                    ->on('careers')
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
        Schema::dropIfExists('career_program');
    }
}
