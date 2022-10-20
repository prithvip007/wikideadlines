<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocumentTypeSupportToQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('date_questions', function (Blueprint $table) {
            $table->string('question_document_to_send', 100)->nullable();
            $table->string('question_document_received', 100)->nullable();
        });


        // Get records from old column.
        $results = DB::table('date_questions')->select('question_document_to_send')->get();

        DB::statement('UPDATE date_questions SET
                question_document_to_send = input_question_text, 
                question_document_received = input_question_text
        ;');

        Schema::table('date_questions', function (Blueprint $table) {
            $table->string('question_document_to_send')->nullable(false)->change();
            $table->string('question_document_received', 100)->nullable(false)->change();
        });


        Schema::table('date_questions', function (Blueprint $table) {
            $table->dropColumn('input_question_text');
            $table->dropColumn('output_question_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('date_questions', function (Blueprint $table) {
            $table->string('input_question_text', 100)->nullable();
            $table->string('output_question_text', 100)->nullable();
        });

        DB::statement('UPDATE date_questions SET
            input_question_text = question_document_to_send,
            output_question_text = question_document_to_send;
        ');

        Schema::table('date_questions', function (Blueprint $table) {
            $table->string('input_question_text', 100)->nullable(false)->change();
            $table->string('output_question_text', 100)->nullable(false)->change();
        });

        Schema::table('date_questions', function (Blueprint $table) {
            $table->dropColumn('question_document_to_send');
            $table->dropColumn('question_document_received');
        });
    }
}
