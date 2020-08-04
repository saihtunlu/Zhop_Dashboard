<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategory3sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category3s', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('value')->nullable();
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->BigInteger('category2_id')->unsigned()->nullable();
            $table->foreign('category2_id')
                ->references('id')->on('category2s')->onDelete('cascade');
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
        Schema::dropIfExists('category3s');
    }
}
