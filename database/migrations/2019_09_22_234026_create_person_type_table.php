<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonTypeTable extends Migration
{
    public function up()
    {
        Schema::create('person_type', function (Blueprint $table) {
            $table->bigInteger('person_id')->unsigned();
            $table->bigInteger('type_id')->unsigned();

            $table->foreign('person_id')
                    ->references('id')
                    ->on('people')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('type_id')
                    ->references('id')
                    ->on('types')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('person_type');
    }
}
