<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CartAddAddresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing carts
        Schema::table('cart', function (Blueprint $table) {
            $table->integer('coupon_id')->unsigned()->after('session_id');
            $table->integer('billing_address_id')->unsigned()->after('session_id');
            $table->integer('shipping_address_id')->unsigned()->after('session_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->dropColumn('shipping_address_id');
            $table->dropColumn('billing_address_id');
            $table->dropColumn('coupon_id');
        });
    }
}
