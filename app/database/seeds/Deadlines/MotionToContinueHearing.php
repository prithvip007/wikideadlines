<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class MotionToContinueHearing extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Motion to continue (postpone) trial/hearing [Motion]',
            'keywords' => 'opposition, reply',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->deadlines()->create([
            'name' => 'File your motion as soon as possible! The continuance motion must be made “as soon as reasonably practical once the necessity for the continuance is discovered.” [CRC 3.1332 (b)]',
            'days' => -16,
            'best_practices' => 'A Motion to Continue is a request by one or both parties in a legal dispute to the Court to extend or reschedule a hearing or trial date to a specified new date. If you have good cause to delay a hearing or trial, you must file a Motion to
            Continue with the Court.
            Please note, under the Trial Court Delay Reduction Act, Courts are required to ensure the prompt disposition of civil cases. Therefore, granting a Motion
            to Continue are generally disfavored by courts.
            The following are potentially good cause for a trial continuance:
            Unavailability of an essential witness;
            Unavailability of another party due to death or other excusable
            circumstance;
            Unavailability of trial counsel because of death, illness, or other
            excusable circumstance; and/or
            Substitution of trial counsel where there is an “affirmative showing that
            the substitution is required in the interests of justice.”',
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
