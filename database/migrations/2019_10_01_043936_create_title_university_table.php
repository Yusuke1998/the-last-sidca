<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTitleUniversityTable extends Migration
{
    public function up()
    {
        Schema::create('title_university', function (Blueprint $table) {
            $table->bigIncrements('id');
            
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
        Schema::dropIfExists('title_university');
    }
}
