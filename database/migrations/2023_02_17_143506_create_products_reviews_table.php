<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->nullable()->index();
            $table->string('order_code')->index();
            $table->integer('order_product_id')->index();
            $table->integer('product_id')->index();
            $table->integer('review_star')->default(5);
            $table->longText('review_text')->nullable();
            $table->integer('is_active')->default(0)->comment('1 means active, 0 means pending, 2 means rejected.');
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
        Schema::dropIfExists('products_reviews');
    }
}
