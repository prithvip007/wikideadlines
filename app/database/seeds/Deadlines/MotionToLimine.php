<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class MotionToLimine extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Motion in Limine',
            'keywords' => 'opposition, reply',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true,
            'days_before_hd_court' => 16
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([1, 10]);

        $document->deadlines()->create([
            'name' => 'The earliest date a Motion in Limine can be filed before trial.   Generally, the earliest a Motion in Limine (motion on the doorstep of trial) can be filed is 40 calendar days before the first date of the trial.',
            'days' => -40,
            'best_practices' => 'There is no statutorily-required form for in limine motions, but local rules may require them to be written and may prescribe the format and contents. See, e.g., San Francisco Ct R 6.1; Los Angeles Ct R 3.57.   A motion in limine is subject to the rules applicable to motions generally, including the requirement that counsel meet and confer. See local Rules and by department.   The purpose of a motion in limine is to prevent the introduction of matters at trial which are irrelevant, inadmissible or prejudicial or to cause the introduction of certain evidence.',
            'days_type' => 'calendar',
            'add_to' => 'td',
        ]);

        $document->deadlines()->create([
            'name' => 'Generally, the latest Motion in Limine (motion on the doorstep of trial) can be filed is 1 calendar day before the first date of the trial.',
            'days' => -1,
            'days_type' => 'calendar',
            'add_to' => 'td',
        ]);
    }
}
