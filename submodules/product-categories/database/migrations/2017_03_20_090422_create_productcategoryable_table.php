<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductcategoryableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productcategoryables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_category_id')->unsigned();
            $table->integer('productcategoryable_id')->unsigned();
            $table->string('productcategoryable_type');
            $table->integer('position')->unsigned();
            $table->timestamps();
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('productcategoryables');
    }
}
