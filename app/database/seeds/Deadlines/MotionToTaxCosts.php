<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class MotionToTaxCosts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Motion to tax costs',
            'keywords' => 'opposition, reply',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([8]);

        $document->deadlines()->create([
            'name' => 'Good time to check for the court\'s availability to hear the motion (the court may only hear motions on certain days of the week, or be dark (closed) for a few days or even a week - so you can\'t wait until 17 days before you want a motion heard to reserve a hearing date).',
            'days' => -23,
            'days_type' => 'court',
            'add_to' => 'hd',
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
            'name' => 'A Reply to a motion must be filed with the court 5 court days before the hearing',
            'days' => -5,
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
            'name' => 'Any notice of motion to strike or to tax costs must be served and filed 15 days after service of the cost memorandum. If the cost memorandum was served by mail, the period is extended as provided in Code of Civil Procedure section 1013. If the cost memorandum was served electronically, the period is extended as provided in Code of Civil Procedure section 1010.6(a)(4)',
            'days' => 15,
            'days_type' => 'calendar',
            'add_to' => 'dmocs',
        ]);

        $document->deadlines()->create([
            'name' => 'An Opposition to a motion must be filed with the court 9 court days before the motion hearing date.',
            'days' => -9,
            'days_type' => 'court',
            'add_to' => 'hd',
        ]);

        $document->deadlines()->create([
            'name' => 'CCP 685.070(c) Within 10 days after the memorandum of costs is served on the judgment debtor, the judgment debtor may apply to the court on noticed motion to have the costs taxed by the court. The notice of motion shall be served on the judgment creditor. Service shall be made personally or by mail. The court shall make an order allowing or disallowing the costs to the extent justified under the circumstances of the case. (d) If no motion to tax costs is made within the time provided in subdivision (c), the costs claimed in the memorandum are allowed.',
            'days' => -16,
            'best_practices' => 'The Service Date for the service of the Memorandum of Costs is extended by 5 Calendar days if service is by mail within Cal. 10 days mailed outside Cal. and 20 days if mailed internationally.',
            'days_type' => 'court',
            'add_to' => 'hd',
            'subtract_delivery_days' => true,
            'check_dps_preciseness' => true,
        ]);

        $document->deadlines()->create([
            'name' => 'The last date to conduct a Meet and Confer regarding the motion (must be done by phone or in-person)',
            'days' => -5,
            'days_type' => 'calendar',
            'add_to' => 'fcd',
            'subtract_delivery_days' => true,
        ]);

        $document->deadlines()->create([
            'name' => 'A Responding party must file any responsive pleading (demurrer, motion to strike, motion to quash, answer, or cross-complaint) within 30 calendar days of service of the complaint or cross-complaint on that party.',
            'days' => 30,
            'days_type' => 'calendar',
            'add_to' => 'dsococcic',
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
