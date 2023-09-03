<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->index();
            $table->string('code')->index();
            $table->integer('customer_id')->nullable()->index();
            $table->double('price');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable()->index();
            $table->string('city')->nullable();
            $table->integer('district_id');
            $table->integer('area_id');
            $table->text('shipping_address')->nullable();
            $table->integer('ship_to_another_address_status')->default(0);
            $table->text('ship_to_another_address')->nullable();
            $table->integer('coupon_status')->default(0);
            $table->string('coupon_code')->nullable();
            $table->string('coupon_discount_amount')->nullable();
            $table->integer('delivery_boy_id')->nullable();
            $table->double('delivery_charge')->nullable();
            $table->double('vat')->nullable();
            $table->string('order_status')->default('Order Created');
            $table->string('payment_status')->default(0);
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('total_payable')->default(0);
            $table->string('paid')->default(0);
            $table->string('sender_amount')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
