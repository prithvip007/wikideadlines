<?php

namespace Seeds;

use Illuminate\Database\Seeder;
use \App\Models\DateQuestion;
use \App\Models\DateQuestionType;

class DateQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DateQuestionType::create([
            'id' => 1,
            'type' => 'date'
        ]);

        DateQuestionType::create([
            'id' => 2,
            'type' => 'datetime'
        ]);

        DateQuestion::create([
            'id' => 1,
            'question_document_to_send' => 'Date on Proof of Service',
            'question_document_received' => 'Proof of Service Date',
            'required' => true,
            'reference_key' => 'dps',
            'date_question_type_id' => 1
        ]);

        DateQuestion::create([
            'id' => 2,
            'question_document_to_send' => 'Hearing Date and Time',
            'question_document_received' => 'Estimated Hearing Date',
            'reference_key' => 'hd',
            'required' => true,
            'date_question_type_id' => 2
        ]);

        DateQuestion::create([
            'id' => 3,
            'question_document_to_send' => 'Earliest date the Complaint or Cross-Complaint was served',
            'question_document_received' => 'Earliest date the Complaint or Cross-Complaint was served',
            'required' => true,
            'date_question_type_id' => 1
        ]);

        DateQuestion::create([
            'id' => 4,
            'question_document_to_send' => 'Date Complaint or Cross-Complaint Filed',
            'question_document_received' => 'Date Complaint or Cross-Complaint Filed',
            'required' => true,
            'date_question_type_id' => 1
        ]);

        DateQuestion::create([
            'id' => 5,
            'question_document_to_send' => 'Date answer filed',
            'question_document_received' => 'Date answer filed',
            'required' => true,
            'date_question_type_id' => 1
        ]);

        DateQuestion::create([
            'id' => 6,
            'question_document_to_send' => 'First Trial Date Set',
            'question_document_received' => 'First Trial Date Set',
            'required' => false,
            'date_question_type_id' => 2
        ]);

        DateQuestion::create([
            'id' => 7,
            'question_document_to_send' => 'Trial Date',
            'question_document_received' => 'Trial Date',
            'required' => false,
            'date_question_type_id' => 2
        ]);

        DateQuestion::create([
            'id' => 8,
            'question_document_to_send' => 'Entry of Judgment Date',
            'question_document_received' => 'Entry of Judgment Date',
            'required' => true,
            'date_question_type_id' => 1
        ]);

        DateQuestion::create([
            'id' => 9,
            'question_document_to_send' => 'Last Date of Arbitration',
            'question_document_received' => 'Last Date of Arbitration',
            'required' => true,
            'date_question_type_id' => 1
        ]);

        DateQuestion::create([
            'id' => 10,
            'question_document_to_send' => 'Hearing Date and Time',
            'question_document_received' => 'Hearing Date',
            'reference_key' => 'earliest_hd_date',
            'required' => false,
            'date_question_type_id' => 2
        ]);

        DateQuestion::create([
            'id' => 11,
            'question_document_to_send' => 'First Scheduled Trial Date',
            'question_document_received' => 'First Scheduled Trial Date',
            'reference_key' => 'first_scheduled_td',
            'required' => false,
            'date_question_type_id' => 2
        ]);
    }
}
