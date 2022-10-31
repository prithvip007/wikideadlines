<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class MotionForSummaryJudgment extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Motion for Summary Judgment',
            'keywords' => 'Request for Continuance, opposition, reply',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([1]);

        $document->deadlines()->create([
            'name' => 'The earliest date a Motion for Summary Judgment can be served on any party in an action is 60 calendar days after the party against whom the motion is filed has generally appeared (i.e. they are not disputing service or jurisdiction) in the action.',
            'days' => 60,
            'days_type' => 'calendar',
            'add_to' => 'opa',
        ]);

        $document->deadlines()->create([
            'name' => 'Deadline to have a Motion for Summary Judgment heard (must be heard 30 days before trial)',
            'days' => -30,
            'days_type' => 'calendar',
            'add_to' => 'td',
        ]);

        $document->deadlines()->create([
            'name' => 'Motion for Summary Judgment Must be filed at least 105 days before the trial date. (CCP 437c)',
            'days' => -105,
            'best_practices' => 'Notice is required to be given at least 75 calendar days before the hearing plus time for service. (mail: +5 w/i Cal. +10 if outside CA, +20 if outside US Fax/Express mail/ +2 days.) [CCP 437c(a)] The Opposition is due 14 calendar days before the hearing [CCP 437c(b)(2)] and must be served the next business day. [CCP., §§ 437c(b)(6), 1005(c).] The Reply is due 5 calendar days before the hearing. [CCP 437c(b)(3)] It also must be served by the next business day. The Motion for Summary Judgment must be heard 30 calendar days before the trial date. [CCP 437c(a)]  This 30 calendar day time limit can be modified by the court for “good cause.” [CCP 437c(a)] Note: A MSJ must be filed at least 105 calendar days before trial, longer depending on the method of service. KEY: Sections 1005 and 1013, extending the time within which a right may be exercised or an act may be done, do not apply to this MSJ Except for subdivision (c) of Section 1005 relating to the method of service of opposition and reply papers related to the MSJ.',
            'days_type' => 'calendar',
            'add_to' => 'td',
        ]);

        $document->deadlines()->create([
            'name' => 'An opposition to the motion shall be served and filed not less than 14 days preceding the noticed or continued date of hearing unless the court for good cause orders otherwise.  CCP 437c.b.2.',
            'days' => -14,
            'days_type' => 'calendar',
            'add_to' => 'hd',
        ]);

        $document->deadlines()->create([
            'name' => 'Deadline to file a Request for Continuance for a Motion for Summary Judgment with the court',
            'days' => -14,
            'days_type' => 'calendar',
            'add_to' => 'hd',
        ]);

        $document->deadlines()->create([
            'name' => 'Deadline to file a reply to an opposition to a Motion for Summary Judgment with the court',
            'days' => -5,
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
