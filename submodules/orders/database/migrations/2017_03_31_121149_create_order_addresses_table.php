<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('user_address_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('address');
            $table->string('address2');
            $table->string('postcode');
            $table->string('phone');
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order_addresses');
    }
}
