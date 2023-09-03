<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('type')->default(2)->comment('1 = admin, 2 = customer, 3 = crm');
            $table->string('districts')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->string('image')->nullable();
            $table->integer('is_active')->default(1);
            $table->integer('referral_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verification_code')->nullable();
            $table->integer('is_phone_verified')->default(0);
            $table->string('wallet_amount')->default(0);
            $table->string('used_wallet_amount')->default(0);
            $table->string('wallet_point')->default(0);
            $table->string('used_wallet_point')->default(0);
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
