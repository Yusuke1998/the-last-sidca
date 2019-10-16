<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationsTable extends Migration
{
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');

            $table->bigInteger('postgraduate_id')->unsigned(); #postgrado
            $table->foreign('postgraduate_id')
                ->references('id')
                ->on('postgraduates')
                ->ondDelete('cascade')
                ->onUpdate('cascade');

            $table->bigInteger('teacher_id')->unsigned(); #docente
            $table->foreign('teacher_id')
                ->references('id')
                ->on('teachers')
                ->ondDelete('cascade')
                ->onUpdate('cascade');

            $table->bigInteger('ascent_id')->unsigned(); #acenso
            $table->foreign('ascent_id')
                ->references('id')
                ->on('ascents')
                ->ondDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('publications');
    }
}