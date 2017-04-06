<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class OrdersModifyTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('total', 20, 2)->default(0)->after('user_id');
            $table->decimal('shipping', 20, 2)->default(0)->after('user_id');
            $table->decimal('discount', 20, 2)->default(0)->after('user_id');
            $table->decimal('tax', 20, 2)->default(0)->after('user_id');
            $table->decimal('base_price', 20, 2)->default(0)->after('user_id');

            $table->integer('coupon_id')->unsigned()->nullable()->after('user_id');
            $table->integer('billing_address_id')->unsigned()->after('user_id');
            $table->integer('shipping_address_id')->unsigned()->after('user_id')   ;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('shipping_address_id');
            $table->dropColumn('billing_address_id');
            $table->dropColumn('coupon_id');
            $table->dropColumn('base_price');
            $table->dropColumn('tax');
            $table->dropColumn('discount');
            $table->dropColumn('shipping');
            $table->dropColumn('total');
        });
    }
}
