<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DateQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('date_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('input_question_text', 100);
            $table->string('output_question_text', 100);
            $table->string('reference_key', 20)->nullable();
            $table->boolean('required');
            $table->foreign('date_question_type_id')->references('id')->on('date_question_types');
            $table->unsignedBigInteger('date_question_type_id');
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
        Schema::dropIfExists('date_questions');
    }
}
