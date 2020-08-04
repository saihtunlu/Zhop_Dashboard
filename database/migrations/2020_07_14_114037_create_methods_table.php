<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('methods', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->boolean('isCondition')->default(0);
            $table->string('condition')->nullable();
            $table->string('type');
            $table->string('initialWeight')->nullable();
            $table->string('initialPrice')->nullable();
            $table->string('pricePerKg')->nullable();
            $table->string('by')->nullable();
            $table->string('with')->nullable();
            $table->string('price')->nullable();
            $table->BigInteger('shipping_id')->unsigned()->nullable();
            $table->foreign('shipping_id')
                ->references('id')->on('shippings')->onDelete('cascade');
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
        Schema::dropIfExists('methods');
    }
}
