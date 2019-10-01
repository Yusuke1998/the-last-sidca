<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherTitleTable extends Migration
{
    public function up()
    {
        Schema::create('teacher_title', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('teacher_id')->unsigned(); #profesor
            $table->foreign('teacher_id')
                    ->references('id')
                    ->on('teachers')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->bigInteger('title_id')->unsigned(); #titulo
            $table->foreign('title_id')
                    ->references('id')
                    ->on('titles')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teacher_title');
    }
}
