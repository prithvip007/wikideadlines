<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class CaseManagementConferenceMinuteOrder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Case Management Conference Minute Order',
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([1, 11]);

        $document->deadlines()->create([
            'name' => 'The date for the filing of any dispositive motions (CCP 437)',
            'days' => -105,
            'best_practices' => 'Motions for Summary Judgment – Notice is 75 days before hearing (+10 if outside CA, +20 if outside US) [CCP 437c(a)].  Opposition is 14 days before the hearing [CCP 437c(b)(2)]. The reply is 5 days before hearing. [CCP 437c(b)(3)]. The motion must be heard 30 days before the trial date. [CCP 437c(a)] Note: This 30 days time limit can be modified by the court for “good cause.”  [CCP 437c(a)] Note:  Practically, this means an MSJ must be filed 105 days before trial',
            'days_type' => 'calendar',
            'add_to' => 'td',
        ]);

        $document->deadlines()->create([
            'name' => 'Experts Must be Demanded (CCP 2034.220)',
            'days' => -70,
            'best_practices' => 'Experts Must Be Demanded – 70 days before trial (or within 10 days of setting a trial date, whichever is closer to the trial date). [CCP 2034.220].',
            'days_type' => 'calendar',
            'add_to' => 'td',
        ]);

        $document->deadlines()->create([
            'name' => 'Experts Must be Disclosed (CCP 2034.230)',
            'days' => -50,
            'best_practices' => 'The demand shall specify the date for the exchange of lists of expert trial witnesses, expert witness declarations, and any demanded production of writings. The specified date of exchange shall be 50 days before the initial trial date, or 20 days after service of the demand, whichever is closer to the trial date, unless the court, on motion and a showing of good cause, orders an earlier or later date of exchange). [CCP 2034.230].',
            'days_type' => 'calendar',
            'add_to' => 'td',
        ]);

        $document->deadlines()->create([
            'name' => 'Discovery Cut-Off Date (CCP 2034.210;  CCP § 1141.24)',
            'days' => -30,
            'best_practices' => 'Discovery can no longer be initiated starting 30 days before trial, or after non-binding arbitration. Serve discovery requests so that responses are due at least 30 days prior to the trial date. [CCP 2034.210;  CCP § 1141.24].',
            'days_type' => 'calendar',
            'add_to' => 'td',
        ]);

        $document->deadlines()->create([
            'name' => 'Discovery Motion Cut-Off Date',
            'days' => -30,
            'days_type' => 'calendar',
            'add_to' => 'td',
        ]);

        $document->deadlines()->create([
            'name' => 'Last date to send Notice to Appear at Trial to a Party (with documents)',
            'days' => -20,
            'days_type' => 'calendar',
            'add_to' => 'td',
        ]);

        $document->deadlines()->create([
            'name' => 'Last date to send Notice to Appear at Trial to a Party (without documents)',
            'days' => -10,
            'days_type' => 'calendar',
            'add_to' => 'td',
        ]);

        $document->deadlines()->create([
            'name' => 'The last date to send a CCP 998 offer to settle is 10 calendar days before trial',
            'days' => -10,
            'days_type' => 'calendar',
            'add_to' => 'td',
        ]);

        $document->deadlines()->create([
            'name' => 'Trial Date',
            'days' => 0,
            'days_type' => 'calendar',
            'add_to' => 'td',
        ]);
    }
}
