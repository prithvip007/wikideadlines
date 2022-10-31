<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class ReceiptOfSignedAcknowledgementOfReceiptOfSummons extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Receipt of signed "Acknowledgement of Receipt of Summons"'
        ]);

        $document->deliveryMethods()->sync([1, 2]);

        $document->deadlines()->create([
            'name' => 'A summons may be served by Acknowledge of Receipt of Summons if sent by mail.  A copy of the summons and of the complaint shall be mailed (by first-class mail or airmail, postage prepaid) to the person to be served, together with two copies of the Notice and Acknowledgment along with a return envelope, postage prepaid, addressed to the sender.   If the served party does not sign the Acknowledgement of Receipt of Summons and mail it within 20 calendar days of the date of mailing to the recipient, then that party then becomes responsible for any further costs of service.',
            'days' => 20,
            'days_type' => 'calendar',
            'add_to' => 'dps',
        ]);
    }
}
