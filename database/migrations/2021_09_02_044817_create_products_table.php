<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id()->index();
            $table->string('title')->index();
            $table->integer('brand_id')->nullable()->index();
            $table->integer('category_id')->nullable()->index();
            $table->integer('sub_category_id')->nullable()->index();
            $table->string('purchase_price')->nullable();
            $table->double('price');
            $table->string('discount_type')->nullable()->index();
            $table->double('discount_amount')->nullable();
            $table->integer('current_stock')->default(0);
            $table->integer('is_featured')->default(0)->index();
            $table->integer('is_tranding')->default(0)->index();
            $table->integer('todays_deal')->default(0);
            $table->string('sold_qty')->default(0);
            $table->string('code')->nullable()->index();
            $table->string('unit_type')->nullable();
            $table->string('type')->nullable()->index();
            $table->integer('minimum_qty')->nullable();
            $table->string('thumbnail_image')->nullable();
            $table->string('thumbnail_image2')->nullable();
            $table->string('gallery_images')->nullable();
            $table->string('video_provider')->nullable();
            $table->text('video_link')->nullable();
            $table->text('variant_product')->nullable();
            $table->text('attributes')->nullable();
            $table->text('choice_options')->nullable();
            $table->text('colors')->nullable();
            $table->text('variations')->nullable();
            $table->longText('feature')->nullable();
            $table->longText('description')->nullable();
            $table->text('pdf_specification')->nullable();
            $table->integer('is_active')->default(1)->index();            
            $table->text('tags')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('meta_image')->nullable();
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
        Schema::dropIfExists('products');
    }
}
