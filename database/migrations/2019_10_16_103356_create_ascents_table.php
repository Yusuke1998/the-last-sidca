<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAscentsTable extends Migration
{
    public function up()
    {
        Schema::create('ascents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('time'); #tiempo para acender
            $table->enum('modality',['art. 61','art. 64','publicacion']); #modalidad

            $table->bigInteger('teacher_id')->unsigned(); #docente
            $table->foreign('teacher_id')
                ->references('id')
                ->on('teachers')
                ->ondDelete('cascade')
                ->onUpdate('cascade');

            $table->bigInteger('current_category_id')->unsigned(); #categoria actual
            $table->foreign('current_category_id')
                ->references('id')
                ->on('categories')
                ->ondDelete('cascade')
                ->onUpdate('cascade');

            $table->bigInteger('next_category_id')->unsigned(); #categoria siguiente
            $table->foreign('next_category_id')
                ->references('id')
                ->on('categories')
                ->ondDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ascents');
    }
}
