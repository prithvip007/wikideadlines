<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class CCPSection998OfferToCompromise extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'CCP 998 Offer to Compromise',
            'keywords' => 'Compromise Settlement'
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->deadlines()->create([
            'name' => 'Any party may serve an offer in writing upon any other party to the action to allow judgment to be taken or an award to be entered in accordance with the terms and conditions stated at that time.  CCP § 998 is a cost-shifting statute that encourages the settlement of actions, by penalizing parties who fail to accept reasonable pretrial settlement offers. A plaintiff who refuses a reasonable pretrial settlement offer and subsequently fails to obtain a “more favorable judgment” is penalized by a loss of prevailing party costs and an award of costs in the defendant’s favor.',
            'days' => -10,
            'best_practices' => 'The CCP 998 Offer is not filed with the court.',
            'days_type' => 'calendar',
            'add_to' => 'td',
        ]);

        $document->deadlines()->create([
            'name' => 'The deadline to accept a CCP 998 Offer to Compromise is "prior to trial or arbitration" - before trial or arbitration begins.  The acceptance must be in writing.',
            'days' => -1,
            'best_practices' => 'A party may file a CCP 998 settlement offer before the second phase of a bifurcated trial so as to take advantage of the useful settlement pressure of potential cost sanctions allowed by the statute. Glende Motor Co. v. Superior Court (Cal. App. 3d Dist. Aug. 21, 1984)',
            'days_type' => 'calendar',
            'add_to' => 'tasd',
        ]);

        $document->deadlines()->create([
            'name' => 'The deadline to accept a CCP 998 Offer to Compromise is 30 calendar days from the date of service.   Acceptance must be in writing.  After 30 days, the offer is automatically withdrawn.',
            'days' => 30,
            'best_practices' => 'The 998 offer remains open for 30 days, although it may be revoked at any time before acceptance.',
            'days_type' => 'calendar',
            'add_to' => 'dps',
        ]);
    }
}
