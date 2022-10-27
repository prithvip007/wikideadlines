<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class MotionForSanctions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Motion for Sanctions [CCP 128.7]',
            'keywords' => 'opposition, reply',
            'small_description' => 'filed with the court',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([1]);

        $document->deadlines()->create([
            'name' => 'The moving party must file the motion and serve it at least 16 court days before the first hearing date is set.',
            'days' => -16,
            'best_practices' => 'Any time during a case, if a party sees a frivolous or harassing pleading by an opposing party, they may initiate the CCP 128.7 sanctions demand procedure. This section does not apply to disclosures and discovery requests, responses, objections, and motions.',
            'days_type' => 'court',
            'add_to' => 'hd',
        ]);

        $document->deadlines()->create([
            'name' => 'Opposition must be filed with the court 9 court days before the first hearing date set and served on the opposing side no less than one business day after it is filed with the court.',
            'days' => -9,
            'days_type' => 'court',
            'add_to' => 'hd',
        ]);

        $document->deadlines()->create([
            'name' => 'A reply must be filed with the court 5 court days before the first hearing date set and served on the opposing side no less than one business day after it is filed with the court.',
            'days' => -5,
            'days_type' => 'court',
            'add_to' => 'hd',
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
