<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Messages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id_message');
            $table->dateTime('created_at');
            $table->longText('text')->nullable();
            $table->boolean('file');
            $table->boolean('status');
            $table->bigInteger('id_from')->unsigned();
            $table->foreign('id_from')->references('id')->on('users');
            $table->bigInteger('id_to')->unsigned();
            $table->foreign('id_to')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
