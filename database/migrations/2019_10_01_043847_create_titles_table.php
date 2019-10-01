<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTitlesTable extends Migration
{
    public function up()
    {
        Schema::create('titles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->enum('level',['Licenciado','Maestria']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('titles');
    }
}
