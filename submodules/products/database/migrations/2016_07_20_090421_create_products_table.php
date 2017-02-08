<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('sku');
            $table->integer('stock')->unsigned()->nullable();
            $table->decimal('price', 20, 2);
            $table->decimal('tax', 20, 2);
            $table->decimal('shipping', 20, 2);
            $table->index('sku');
            $table->index('price');
            $table->string('image')->nullable();
            $table->timestamps();

        });

        Schema::create('product_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->string('locale');
            $table->boolean('status')->default(0);
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('summary');
            $table->text('body');
            $table->timestamps();
            $table->unique(['product_id', 'locale']);
            $table->unique(['locale', 'slug']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

        });

        Schema::create('product_prices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->boolean('status')->default(0);
            $table->string('currency');
            $table->integer('starting_at')->default(1);
            $table->decimal('specific_price', 20, 2);
            $table->boolean('specific_price_status');
            $table->string('discount');
            $table->integer('discount_type');
            $table->string('date_from');
            $table->string('date_to');
            $table->timestamps();
            $table->index('specific_price');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product_prices');
        Schema::drop('product_translations');
        Schema::drop('products');
    }
}

