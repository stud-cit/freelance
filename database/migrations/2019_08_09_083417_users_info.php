<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_info', function (Blueprint $table) {
            $table->bigInteger('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('users');
            $table->string('name', 45);
            $table->string('surname', 45);
            $table->string('patronymic', 45)->nullable();
            $table->date('birthday_date')->nullable();
            $table->string('phone_number', 45)->nullable();
            $table->string('viber', 45)->nullable();
            $table->string('skype', 45)->nullable();
            $table->text('about_me')->nullable();
            $table->text('country')->nullable();
            $table->text('city')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_info');
    }
}
