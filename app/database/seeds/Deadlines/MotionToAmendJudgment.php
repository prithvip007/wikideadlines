<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class MotionToAmendJudgment extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Motion to Amend Judgment',
            'keywords' => 'Notice of judgment provided, opposition, reply',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true,
            'days_before_hd_court' => 16
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([1, 10, 7]);

        $document->deadlines()->create([
            'name' => 'CCP 473(d) The court may, upon motion of the injured party, or its own motion, correct clerical mistakes in its judgment or orders as entered, so as to conform to the judgment or order directed, and may, on motion of either party after notice to the other party, set aside any void judgment or order.',
            'days' => 15,
            'best_practices' => 'Trial courts lose jurisdiction once a judgment is entered. However, they can correct clerical mistakes in their judgment or order to conform to the judgment or order. The injured party via noticed motion alerts the court to the needed correction.  "Clerical error, however, is to be distinguished from judicial error which cannot be corrected b amendment. In re Candelorio (1970) 3 Cal. 3d 702, 705.',
            'days_type' => 'calendar',
            'add_to' => 'je',
        ]);
    }
}
