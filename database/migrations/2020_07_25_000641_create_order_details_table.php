<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->string('quantity');
            $table->string('product_type');
            $table->BigInteger('order_id')->unsigned()->nullable();
            $table->foreign('order_id')
                ->references('id')->on('orders')->onDelete('cascade');
            $table->BigInteger('product_id')->unsigned()->nullable();
            $table->foreign('product_id')
                ->references('id')->on('products')->onDelete('cascade');
            $table->BigInteger('variation_id')->unsigned()->nullable();
            $table->foreign('variation_id')
                ->references('id')->on('variations')->onDelete('cascade');
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
        Schema::dropIfExists('order_details');
    }
}
