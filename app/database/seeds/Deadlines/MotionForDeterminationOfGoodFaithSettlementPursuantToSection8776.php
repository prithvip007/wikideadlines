<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class MotionForDeterminationOfGoodFaithSettlementPursuantToSection8776 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Motion for Determination of Good Faith Settlement pursuant to Section 877.6.',
            'keywords' => 'Contest, opposition, reply',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->deadlines()->create([
            'name' => 'Within 25 days of the mailing of the notice, application, and proposed order, or within 20 days of personal service, a nonsettling party may file a notice of motion to contest the good faith of the settlement. If none of the nonsettling parties files a motion within 25 days of the mailing of the notice, application, and proposed order, or within 20 days of personal service, the court may approve the settlement. The notice by a nonsettling party shall be given in the manner provided in subdivision (b) of Section 1005. However, this paragraph shall not apply to settlements in which a confidentiality agreement has been entered into regarding the case or the terms of the settlement.',
            'days' => -16,
            'best_practices' => 'Must file and serve the notice of motion to contest the good faith of the settlement within 20 days of personal service of the Notice or 25 days if served by certified mail, return receipt requested',
            'days_type' => 'court',
            'add_to' => 'hd',
        ]);

        $document->deadlines()->create([
            'name' => '',
            'days' => 20,
            'days_type' => 'calendar',
            'add_to' => 'dps',
            'subtract_delivery_days' => true,
        ]);

        $document->deadlines()->create([
            'name' => 'L/D to serve by messenger/hand delivery',
            'days' => 0,
            'days_type' => 'calendar',
            'add_to' => 'hand_delivery',
        ]);

        $document->deadlines()->create([
            'name' => 'L/D to serve by eFile, OneLegal, or email',
            'days' => 0,
            'days_type' => 'calendar',
            'add_to' => 'electronic',
        ]);

        $document->deadlines()->create([
            'name' => 'L/D to serve by fax, or overnight delivery.',
            'days' => -2,
            'days_type' => 'calendar',
            'add_to' => 'email',
        ]);

        $document->deadlines()->create([
            'name' => ' L/D to serve by regular mail from within the State',
            'days' => -5,
            'days_type' => 'calendar',
            'add_to' => 'regular_mail_within_state',
        ]);

        $document->deadlines()->create([
            'name' => 'L/D to serve by regular mail from outside the State but inside the United States.',
            'days' => -10,
            'days_type' => 'calendar',
            'add_to' => 'regular_mail_outside_state',
        ]);

        $document->deadlines()->create([
            'name' => 'L/D to serve by regular mail from outside the United States.',
            'days' => -20,
            'days_type' => 'calendar',
            'add_to' => 'regular_mail_outside_country',
        ]);
    }
}
