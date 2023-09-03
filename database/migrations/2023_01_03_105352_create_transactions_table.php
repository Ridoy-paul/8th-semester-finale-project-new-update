<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('tran_id')->nullable();
            $table->string('which_payment')->nullable()->comment('order payment, wallet');
            $table->string('payment_method')->nullable()->comment('online payment, wallet money, cash on delivery payment');
            $table->string('amount')->default(0);
            $table->string('store_amount')->default(0);
            $table->string('minus_amount')->default(0);
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
        Schema::dropIfExists('transactions');
    }
}
