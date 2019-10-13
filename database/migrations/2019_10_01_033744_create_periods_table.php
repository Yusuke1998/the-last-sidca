<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodsTable extends Migration
{
    public function up()
    {
        Schema::create('periods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->unique();
            $table->string('period')->unique();
            $table->date('date_start');
            $table->date('date_end');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('periods');
    }
}
