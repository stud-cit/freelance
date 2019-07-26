<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Proposals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->bigIncrements('id_proposal');
            $table->string('text', 45);
            $table->bigInteger('id_order')->unsigned();
            $table->foreign('id_order')->references('id_order')->on('orders');
            $table->bigInteger('id_worker')->unsigned();
            $table->foreign('id_worker')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposals');
    }
}
