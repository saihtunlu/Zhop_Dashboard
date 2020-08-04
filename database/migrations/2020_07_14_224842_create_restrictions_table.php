<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestrictionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restrictions', function (Blueprint $table) {
            $table->id();
            $table->string('condition')->nullable();
            $table->string('by');
            $table->string('with')->nullable();
            $table->string('price')->nullable();
            $table->BigInteger('shipping_id')->unsigned()->nullable();
            $table->foreign('shipping_id')
                ->references('id')->on('shippings')->onDelete('cascade');
            $table->BigInteger('payment_id')->unsigned()->nullable();
            $table->foreign('payment_id')
                ->references('id')->on('payments')->onDelete('cascade');
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
        Schema::dropIfExists('restrictions');
    }
}
