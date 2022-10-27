<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class Demurrer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Demurrer',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->deadlines()->create([
            'name' => 'Last date to file and serve the motion.',
            'days' => -16,
            'days_type' => 'court',
            'add_to' => 'hd',
            'subtract_delivery_days' => true,
            'check_dps_preciseness' => true,
        ]);

        $document->deadlines()->create([
            'name' => 'An Opposition to a motion must be filed with the court 9 court days before the motion hearing date.',
            'days' => -9,
            'days_type' => 'court',
            'add_to' => 'hd',
        ]);


        $document->deadlines()->create([
            'name' => 'An Opposition to any motion (other than a Motion for Summary Judgment) must be received by all opposing attorneys or parties (if unrepresented by an attorney) no later than one business day after it was filed with the court.',
            'days' => -8,
            'days_type' => 'court',
            'add_to' => 'hd',
        ]);

        $document->deadlines()->create([
            'name' => 'A Reply to a motion must be filed with the court 5 court days before the hearing',
            'days' => -5,
            'days_type' => 'court',
            'add_to' => 'hd',
        ]);

        $document->deadlines()->create([
            'name' => 'Deadline to Meet and Confer. The parties shall meet and confer at least five calendar days before the date the demurrer is filed (which is typically 25 calendar days after the complaint or cross-complaint was served, however, the responding party may have been given an extension of time to respond). If the parties are not able to meet and confer at least five days prior to the date any responsive pleading is due, including a demurrer, motion to strike, motion to quash or answer; the demurring party shall be granted an automatic 30-day extension of time within which to file any responsive pleading, by filing and serving, on or before the date on which a demurrer would be due, a declaration stating under penalty of perjury that a good faith attempt to meet and confer was made and explaining the reasons why the parties could not meet and confer.',
            'days' => -5,
            'days_type' => 'calendar',
            'add_to' => 'fcd',
        ]);

        $document->deadlines()->create([
            'name' => 'A Reply to any motion (except a Reply on a Motion for Summary Judgment) must be received by all opposing attorneys or parties (if unrepresented by an attorney) no later than one business day after it was filed with the court.',
            'days' => -4,
            'days_type' => 'court',
            'add_to' => 'hd',
        ]);

        $document->deadlines()->create([
            'name' => 'A hearing date for the motion',
            'days' => 0,
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

        // $document->deadlines()->create([
        //     'name' => 'The parties shall meet and confer at least five calendar days before the date the demurrer is filed. (assuming no extension of time to respond was given to the responding party). If the parties are not able to meet and confer at least five days prior to the date any responsive pleading is due, including a demurrer, motion to strike, motion to quash or answer; the demurring party shall be granted an automatic 30-day extension of time within which to file any responsive pleading, by filing and serving, on or before the date on which a demurrer would be due, a declaration stating under penalty of perjury that a good faith attempt to meet and confer was made and explaining the reasons why the parties could not meet and confer.',
        //     'days' => 25,
        //     'days_type' => 'calendar',
        //     'add_to' => 'dsococcic',
        // ]);
    }
}
