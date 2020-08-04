<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variations', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('attribute1_id')->unsigned()->nullable();
            $table->foreign('attribute1_id')
                ->references('id')->on('attribute_details')
                ->onDelete('cascade');
            $table->BigInteger('attribute2_id')->unsigned()->nullable();
            $table->foreign('attribute2_id')
                ->references('id')->on('attribute_details')
                ->onDelete('cascade');
            $table->BigInteger('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');
            $table->string('weight')->nullable();
            $table->bigInteger('sold_out')->default(0);
            $table->string('image')->nullable();
            $table->string('height')->nullable();
            $table->string('width')->nullable();
            $table->string('Length')->nullable();
            $table->string('stock');
            $table->string('number_of_stock')->nullable();
            $table->string('threshold')->nullable();
            $table->string('regular_price')->nullable();
            $table->string('sale_price')->nullable();
            $table->string('discount')->nullable();
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
        Schema::dropIfExists('variations');
    }
}
