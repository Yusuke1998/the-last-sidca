<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaCoreTable extends Migration
{
    public function up()
    {
        Schema::create('area_core', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('area_id')->unsigned(); #area
            $table->foreign('area_id')
                ->references('id')
                ->on('areas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                
            $table->bigInteger('core_id')->unsigned(); #nucleo
            $table->foreign('core_id')
                ->references('id')
                ->on('cores')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('area_core');
    }
}
