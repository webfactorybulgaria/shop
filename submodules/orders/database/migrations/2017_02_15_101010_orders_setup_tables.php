<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class OrdersSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('order_status', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('code', 32);
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->primary('code');
        });
        // Create table for storing carts
        Schema::create('orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->string('statusCode', 32);
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('statusCode')
                ->references('code')
                ->on('order_status')
                ->onUpdate('cascade');
            $table->index(['user_id', 'statusCode']);
            $table->index(['id', 'user_id', 'statusCode']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('orders');
        Schema::drop('order_status');
    }
}
