<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id()->index();
            $table->string('title')->index();
            $table->integer('parent_id')->default(0);
            $table->integer('is_menu_active')->default(0);
            $table->integer('menu_position')->nullable();
            $table->integer('position')->default(1);
            $table->string('image')->nullable();
            $table->string('banner')->nullable();
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_image')->nullable();
            $table->string('meta_description')->nullable();
            $table->integer('is_featured')->default(0)->index();
            $table->integer('is_menu_item')->default(0)->index();
            $table->integer('publish_product_in_home_page')->default(0)->index();
            $table->integer('is_active')->default(1)->index();
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
        Schema::dropIfExists('categories');
    }
}
