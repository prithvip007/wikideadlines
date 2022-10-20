<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class AntiSLAAPMotion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Anti-SLAAP Motion',
            'keywords' => 'Opposition to Anti-SLAAP Motion, Reply to Opposition to Anti-SLAAP Motion, Last date to file Anti-SLAAP Motion, opposition, reply',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);
        $document->dateQuestions()->sync([1, 3, 4]);

        // $document->deadlines()->create([
        //     'name' => 'A Reply to a motion must be filed with the court 5 court days before the hearing',
        //     'days' => -5,
        //     'days_type' => 'court',
        //     'add_to' => 'hd'
        // ]);

        $document->deadlines()->create([
            'name' => 'An Opposition to any motion (other than a Motion for Summary Judgment) must be received by all opposing attorneys or parties (if unrepresented by an attorney) no later than one business day after it was filed with the court.',
            'days' => -8,
            'best_practices' => 'Service of opposition must be either via email (by stipulation of the parties) or overnight mail. CCP 1005(c)',
            'days_type' => 'court',
            'add_to' => 'hd',
        ]);

        // $document->deadlines()->create([
        //     'name' => 'Last date to file and serve the motion',
        //     'days' => -16,
        //     'days_type' => 'court',
        //     'add_to' => 'hd',
        //     'subtract_delivery_days' => true,
        //     'check_dps_preciseness' => true
        // ]);

        // $document->deadlines()->create([
        //     'name' => 'An Opposition to a motion must be filed with the court 9 court days before the motion hearing date.',
        //     'days' => -9,
        //     'days_type' => 'court',
        //     'add_to' => 'hd'
        // ]);

        // $document->deadlines()->create([
        //     'name' => 'Hearing date for the motion',
        //     'days' => 0,
        //     'days_type' => 'court',
        //     'add_to' => 'hd'
        // ]);

        // $document->deadlines()->create([
        //     'name' => 'A Repy to a motion must be filed with the court 5 court days before the hearing',
        //     'days' => -5,
        //     'days_type' => 'court',
        //     'add_to' => 'hd'
        // ]);



        // $document->deadlines()->create([
        //     'name' => 'Deadline to file a writ challenging any order - although it is recommended writs be filed within 5 court days after notice of entry of an order',
        //     'days' => 60,
        //     'days_type' => 'calendar',
        //     'add_to' => 'hd'
        // ]);

        // $document->deadlines()->create([
        //     'name' => 'Last date to conduct a Meet and Confer regarding the motion (must be done by phone or in person)',
        //     'days' => -16,
        //     'days_type' => 'court',
        //     'add_to' => 'hd'
        // ]);


        $document->deadlines()->create([
            'name' => 'Reserve Hearing Date with the Court Calendaring Clerk (only if you\'re filing the motion) at least 23 days before you want the motion to be heard',
            'days' => -23,
            'days_type' => 'court',
            'best_practices' => 'Good time to check for the court\'s availability to hear the motion (the court may only hear motions on certain days of the week, or be dark (closed) for a few days or even a week - so you can\'t wait until 17 days before you want a motion heard to reserve a hearing date).',
            'add_to' => 'hd',
            'subtract_delivery_days' => true,
        ]);

        // $document->deadlines()->create([
        //     'name' => 'A preemptive motion to dismiss the case on the ground that it is a bad faith attempt to chill exercise of rights to speech or to petition government on an issue of public concern; affidavit is allowed',
        //     'days' => -60,
        //     'days_type' => 'calendar',
        //     'add_to' => 'hd'
        // ]);

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
