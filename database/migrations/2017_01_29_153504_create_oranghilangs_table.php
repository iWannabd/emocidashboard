<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOranghilangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oranghilangs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('address');
            $table->string('usia');
            $table->string('sex');
            $table->string('img');
            $table->boolean('validate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oranghilangs');
    }
}
