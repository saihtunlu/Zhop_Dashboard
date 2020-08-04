<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_details', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('attribute_id')->unsigned();
            $table->foreign('attribute_id')
                ->references('id')->on('attributes')
                ->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('color')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('attribute_details');
    }
}
