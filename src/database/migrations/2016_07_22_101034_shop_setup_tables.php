<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ShopSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing carts
        Schema::create('cart', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->string('session_id');
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unique(['user_id', 'session_id']);
        });
        // Create table for storing items
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->string('session_id');
            $table->bigInteger('cart_id')->unsigned()->nullable();
            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->string('sku');
            $table->decimal('price', 20, 2);
            $table->decimal('tax', 20, 2)->default(0);
            $table->decimal('shipping', 20, 2)->default(0);
            $table->decimal('discount', 20, 2)->default(0);
            $table->string('currency')->nullable();
            $table->integer('quantity')->unsigned();
            $table->integer('shoppable_id')->nullable();
            $table->string('shoppable_type')->nullable();
            $table->char('attributes_hash', 40);
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('cart_id')
                ->references('id')
                ->on('cart')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->index(['user_id', 'sku']);
            $table->index(['user_id', 'sku', 'cart_id']);
            $table->index(['user_id', 'sku', 'order_id']);
            $table->index(['reference_id']);
            $table->index(['attributes_hash']);
        });
        // Create table for storing item attributes
        Schema::create('item_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('item_id')->unsigned();
            $table->string('attribute_object_id')->nullable();
            $table->string('attribute_object_type')->nullable();

            $table->timestamps();
            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        // Create table for storing transactions
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned();
            $table->string('gateway', 64);
            $table->string('transaction_id', 64);
            $table->string('detail', 1024)->nullable();
            $table->string('token')->nullable();
            $table->timestamps();
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->index(['order_id']);
            $table->index(['gateway', 'transaction_id']);
            $table->index(['order_id', 'token']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('transactions');
        Schema::drop('item_attributes');
        Schema::drop('items');
        Schema::drop('cart');
    }
}
