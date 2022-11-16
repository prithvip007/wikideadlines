<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class NoticeOfMotionForSanctionsBeforeFiledWithTheCourt extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Notice of Motion for Sanctions [CCP 128.7]',
            'keywords' => 'opposition, reply NoticOfMotion' ,
            'small_description' => 'before motion is filed with the court',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true,
            'days_before_hd_court' => 16
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([10]);

        $document->deadlines()->create([
            'name' => 'The sender must wait 21 calendar days after sending a CCP 128.7  Notice of Motion and Motion for Sanctions before they can file the CCP 128.7 Motion with the court.  If the receiving party dismisses or modifies the offending portion of the complaint before the 21-day "safe harbor" period ends, then the sending party cannot then file the Motion for Sanctions.   ',
            'days' => 21,
            'best_practices' => 'Any time during a case, if a party sees a frivolous or harassing pleading by an opposing party, they may initiate the CCP 128.7 sanctions demand procedure.',
            'days_type' => 'calendar',
            'add_to' => 'dps',
        ]);
    }
}
