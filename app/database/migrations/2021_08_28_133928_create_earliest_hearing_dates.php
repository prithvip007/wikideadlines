<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEarliestHearingDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earliest_hearing_dates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('value');
            $table->foreign('delivery_method_id')->references('id')->on('delivery_methods');
            $table->unsignedBigInteger('delivery_method_id');
            $table->foreign('calculation_id')->references('id')->on('calculations');
            $table->unsignedBigInteger('calculation_id');
            $table->unique(['calculation_id', 'delivery_method_id']);
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
        Schema::dropIfExists('earliest_hearing_dates');
    }
}
