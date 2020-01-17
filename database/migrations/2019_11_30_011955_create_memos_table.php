<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemosTable extends Migration
{
    public function up()
    {
        Schema::create('memos', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('cu_code')->nullable(); #codigo de consejo universitario
            $table->date('cu_date')->nullable(); #fecha de emision por cu
            $table->string('vrac_code')->nullable(); #codigo de vicerectorado academico
            $table->date('vrac_date')->nullable(); #fecha de vrac
            $table->string('area_code')->nullable(); #codigo de area
            $table->date('area_date')->nullable(); #fecha de area academica

            $table->bigInteger('ascent_id')->unsigned(); #docente
            $table->foreign('ascent_id')
                ->references('id')
                ->on('ascents')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('memos');
    }
}
