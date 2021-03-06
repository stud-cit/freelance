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
            $table->text('text')->nullable();
            $table->string('price', 20)->nullable();
            $table->string('time', 20)->nullable();
            $table->bigInteger('id_order')->unsigned();
            $table->foreign('id_order')->references('id_order')->on('orders');
            $table->bigInteger('id_worker')->unsigned();
            $table->foreign('id_worker')->references('id')->on('users');
            $table->boolean('blocked');
            $table->boolean('checked');
            $table->date('created_at');
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
