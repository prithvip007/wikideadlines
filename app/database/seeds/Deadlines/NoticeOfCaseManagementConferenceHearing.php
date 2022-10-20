<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class NoticeOfCaseManagementConferenceHearing extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Notice of Case Management Conference Hearing',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([1, 5]);

        $document->deadlines()->create([
            'name' => 'The parties shall complete a "meet and confer", in person or by phone, 30 calendar days before each scheduled Case Management Hearing and declare as such on the Case Management Statement.',
            'days' => -30,
            'days_type' => 'calendar',
            'add_to' => 'hd',
        ]);

        $document->deadlines()->create([
            'name' => 'The Case Management Statement must be filed 15 calendar days before the Case Management Conference Hearing.',
            'days' => -15,
            'best_practices' => 'Parties may file a joint statement that they all sign or they may file individual statements.',
            'days_type' => 'calendar',
            'add_to' => 'hd',
        ]);

        $document->deadlines()->create([
            'name' => 'Jury fees ($150 as of 2020) must be paid and a "Notice of Payment of Advance Jury Fee" must be filed and served on all opposing counsel and on any unrepresented party by the date of the first scheduled Case Management Conference (There is no general form for all California courts - here is San Diego\'s form which can be typed into a pleading you can use in all California courts:  http://www.sdcourt.ca.gov/pls/portal/docs/PAGE/SDCOURT/GENERALINFORMATION/FORMS/CIVILFORMS/CIV105.PDF',
            'days' => 0,
            'best_practices' => 'If a party is unrepresented or was represented by a prior attorney who missed the jury fee filing deadline, you should go ahead and try to pay the jury fee and file the notice - even if you\'re past the deadline.   Sometimes the court will still accept it.',
            'days_type' => 'calendar',
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
