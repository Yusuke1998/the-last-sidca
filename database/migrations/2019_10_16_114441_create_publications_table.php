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
            $table->string('rev')->nullable();
            $table->string('code_issn')->nullable();
            $table->string('nro_isbn')->nullable();
            $table->string('nro_edit')->nullable();
            $table->string('vol')->nullable();
            $table->string('date')->nullable();
            $table->string('url')->nullable();

            $table->bigInteger('ascent_id')->unsigned(); #acenso
            $table->foreign('ascent_id')
                ->references('id')
                ->on('ascents')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->bigInteger('teacher_id')->unsigned(); #docente
            $table->foreign('teacher_id')
                ->references('id')
                ->on('teachers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                
            $table->bigInteger('postgraduate_id')->unsigned(); #postgrado
            $table->foreign('postgraduate_id')
                ->references('id')
                ->on('postgraduates')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('publications');
    }
}
