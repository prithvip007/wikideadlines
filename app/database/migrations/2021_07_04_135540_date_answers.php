<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DateAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('date_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('value');
            $table->unsignedBigInteger('date_question_id');
            $table->foreign('date_question_id')->references('id')->on('date_questions');
            $table->unsignedBigInteger('calculation_id');
            $table->foreign('calculation_id')->references('id')->on('calculations');
            $table->unique(['calculation_id', 'date_question_id']);
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
        Schema::dropIfExists('date_answers');
    }
}
