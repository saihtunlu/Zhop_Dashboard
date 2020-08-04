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
            $table->id();
            $table->string('title');
            $table->integer('product_no')->nullable();
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->string('weight')->nullable();
            $table->boolean('featured')->default(0);
            $table->string('height')->nullable();
            $table->bigInteger('sold_out')->default(0);
            $table->string('width')->nullable();
            $table->string('Length')->nullable();
            $table->string('video_link')->nullable();
            $table->string('stock')->nullable();
            $table->string('number_of_stock')->nullable();
            $table->string('threshold')->nullable();
            $table->string('regular_price')->nullable();
            $table->string('sale_price')->nullable();
            $table->BigInteger('brand_id')->unsigned()->nullable();
            $table->foreign('brand_id')
                ->references('id')->on('brands')
                ->onDelete('cascade');
            $table->string('discount')->nullable();
            $table->string('type');
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
