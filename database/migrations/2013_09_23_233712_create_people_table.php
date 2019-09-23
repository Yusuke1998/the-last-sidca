<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->bigInteger('document_id')->unsigned();
            $table->string('nro_document')->unique();
            $table->string('img_document')->default('document-default.jpg');
            $table->date('birthday')->nullable();
            $table->string('direction')->nullable();
            $table->string('local_phone')->nullable();
            $table->string('movil_phone')->nullable();
            $table->string('mail_contact')->nullable();
            $table->timestamps();

            $table->foreign('document_id')
                  ->references('id')
                  ->on('documents')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('people');
    }
}
