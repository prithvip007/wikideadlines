<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class MotionToTransferCaseToAnotherCourt extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Motion to transfer case (change venue) to another court',
            'keywords' => 'opposition, reply ' ,
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true,
            'days_before_hd_court' => 16
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([10, 5]);

        $document->deadlines()->create([
            'name' => '(a) Except as otherwise provided in Section 396a, if an action or proceeding is commenced in a court having jurisdiction of the subject matter thereof, other than the court designated as the proper court for the trial thereof, under this title, the action may, notwithstanding, be tried in the court where commenced, unless the defendant, at the time he or she answers, demurs, or moves to strike, or, at his or her option, without answering, demurring, or moving to strike and within the time otherwise allowed to respond to the complaint, files with the clerk, a notice of motion for an order transferring the action or proceeding to the proper court, together with proof of service, upon the adverse party, of a copy of those papers. Upon the hearing of the motion, the court shall, if it appears that the action or proceeding was not commenced in the proper court, order the action or proceeding transferred to the proper court.',
            'days' => -30,
            'best_practices' => 'Must file Motion to Transfer before Answer or demurrer is due. If extend time to file demurrer ( CCP 430.41(2)  file Motion to transfer along with demurrer.',
            'days_type' => 'calendar',
            'add_to' => 'dps',
        ]);
    }
}
