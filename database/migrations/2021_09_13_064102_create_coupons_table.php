<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id()->index();
            $table->string('name')->nullable();
            $table->string('code')->unique()->index();
            $table->double('discount')->nullable();
            $table->double('amount')->nullable();
            $table->date('valid_from');
            $table->date('valid_to');
            $table->integer('single_use')->default(0);
            $table->integer('affiliate_id')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
