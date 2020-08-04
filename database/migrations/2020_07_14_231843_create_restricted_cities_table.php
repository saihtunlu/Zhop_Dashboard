<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestrictedCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restricted_cities', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->BigInteger('restriction_id')->unsigned()->nullable();
            $table->foreign('restriction_id')
                ->references('id')->on('restrictions')->onDelete('cascade');
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
        Schema::dropIfExists('restricted_cities');
    }
}
