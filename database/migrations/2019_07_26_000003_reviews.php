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
            $table->bigInteger('id_customer')->unsigned();
            $table->foreign('id_customer')->references('id')->on('users');
            $table->bigInteger('id_worker')->unsigned();
            $table->foreign('id_worker')->references('id')->on('users');
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
