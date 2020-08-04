<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('cascade');
            $table->BigInteger('payment_id')->unsigned()->nullable();
            $table->foreign('payment_id')
                ->references('id')->on('payments')->onDelete('cascade');
            $table->string('totalPrice');
            $table->string('payment_method');
            $table->string('status')->default('Pending');
            $table->boolean('paid')->default(0);
            $table->boolean('seen')->default(0);
            $table->string('order_id')->nullable();
            $table->string('totalWeight');
            $table->string('userName');
            $table->string('email');
            $table->string('phone');
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
        Schema::dropIfExists('orders');
    }
}
