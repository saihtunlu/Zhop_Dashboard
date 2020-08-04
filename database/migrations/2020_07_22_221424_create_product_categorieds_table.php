<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categorieds', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');
            $table->BigInteger('category1_id')->unsigned();
            $table->foreign('category1_id')
                ->references('id')->on('category1s');
            $table->BigInteger('category2_id')->unsigned();
            $table->foreign('category2_id')
                ->references('id')->on('category2s');
            $table->BigInteger('category3_id')->unsigned();
            $table->foreign('category3_id')
                ->references('id')->on('category3s');
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
        Schema::dropIfExists('product_categorieds');
    }
}
