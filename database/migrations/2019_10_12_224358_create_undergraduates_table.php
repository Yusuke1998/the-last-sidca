<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUndergraduatesTable extends Migration
{
    public function up()
    {
        Schema::create('undergraduates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            
            $table->bigInteger('teacher_id')->unsigned(); #profesor
            $table->foreign('teacher_id')
                    ->references('id')
                    ->on('teachers')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->bigInteger('university_id')->unsigned(); #universidad
            $table->foreign('university_id')
                    ->references('id')
                    ->on('universities')
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
        Schema::dropIfExists('undergraduates');
    }
}
