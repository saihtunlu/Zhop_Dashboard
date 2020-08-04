<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategory2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category2s', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('value')->nullable();
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->BigInteger('category1_id')->unsigned()->nullable();
            $table->foreign('category1_id')
                ->references('id')->on('category1s')->onDelete('cascade');
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
        Schema::dropIfExists('category2s');
    }
}
