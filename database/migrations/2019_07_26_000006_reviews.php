<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Reviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id_review');
            $table->longText('text');
            $table->float('rating');
            $table->bigInteger('id_from')->unsigned();
            $table->foreign('id_from')->references('id')->on('users');
            $table->bigInteger('id_to')->unsigned();
            $table->foreign('id_to')->references('id')->on('users');
            $table->bigInteger('id_order');
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
        Schema::dropIfExists('reviews');
    }
}
