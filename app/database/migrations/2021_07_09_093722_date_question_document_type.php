<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DateQuestionDocumentType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('date_question_document_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreign('date_question_id')->references('id')->on('date_questions');
            $table->unsignedBigInteger('date_question_id');
            $table->foreign('document_type_id')->references('id')->on('document_types');
            $table->unsignedBigInteger('document_type_id');
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
        //
    }
}
