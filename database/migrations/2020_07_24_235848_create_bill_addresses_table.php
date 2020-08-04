<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_addresses', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('order_id')->unsigned()->nullable();
            $table->foreign('order_id')
                ->references('id')->on('orders')->onDelete('cascade');
            $table->string('state');
            $table->string('city');
            $table->string('addressLine1');
            $table->string('addressLine2');
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
        Schema::dropIfExists('bill_addresses');
    }
}
