<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_entries', function (Blueprint $table) {
            $table->id();
            $table->integer('wallet_id')->unsigned();
            $table->double('cash_in')->nullable();
            $table->double('cash_out')->nullable();
            $table->double('point_in')->nullable();
            $table->double('point_out')->nullable();
            $table->string('note');
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
        Schema::dropIfExists('wallet_entries');
    }
}
