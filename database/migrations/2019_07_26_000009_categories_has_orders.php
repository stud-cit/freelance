<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoriesHasOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_has_orders', function (Blueprint $table) {
            $table->bigInteger('id_category')->unsigned();
            $table->foreign('id_category')->references('id_category')->on('categories');
            $table->bigInteger('id_order')->unsigned();
            $table->foreign('id_order')->references('id_order')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_has_orders');
    }
}
