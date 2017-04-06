<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CouponsSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing coupons
        Schema::create('coupons', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('description', 1024)->nullable();
            $table->string('sku');
            $table->integer('total_available')->default(0);
            $table->integer('total_available_user')->default(0);
            $table->decimal('value', 20, 2)->nullable();
            $table->decimal('discount', 4, 2)->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->timestamps();
            $table->index(['code', 'starts_at']);
            $table->index(['code', 'expires_at']);
            $table->index(['code', 'active']);
            $table->index(['code', 'active', 'expires_at']);
            $table->index(['sku']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('coupons');
    }
}
