<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamicHolidays extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dynamic_holidays', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name');
            $table->enum('order', [0, 1, 2, 3, 4, 5]);
            $table->enum('week_day', [1, 2, 3, 4, 5, 6, 7]);
            $table->enum('month', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]);
            $table->smallInteger('state_id');
            $table->softDeletes();
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
        Schema::dropIfExists('dynamic_holidays');
    }
}
