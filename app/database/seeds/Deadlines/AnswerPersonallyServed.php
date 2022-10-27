<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class AnswerPersonallyServed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Answer',
            'small_description' => 'If complaint personally served',
            'keywords' => 'Response, Demurrer, Strike, Sanctions, 128.7, Quash, Extension, Cross-Complaint, Reply, Pleading',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true
        ]);

        $document->deliveryMethods()->sync([1, 3, 4]);

        $document->dateQuestions()->sync([3, 4]);

        $document->deadlines()->create([
            'name' => 'The answer/response must be filed with the court a maximum of 30 calendar days after the complaint or cross-complaint is hand-delivered to the defendant or cross-defendant unless an extension is granted by the plaintiff, cross-complainant or court. The answer/response must be filed with the court a maximum of 30 calendar days after the complaint or cross-complaint is hand-delivered to the defendant or cross-defendant unless an extension is granted by the plaintiff, cross-complainant or court.',
            'days' => -30,
            'days_type' => 'calendar',
            'best_practices' => 'A party can file an Answer/Response with the court per the method authorized by the local rules (electronic, fax, mail, or at the window) and if none by electronic service if available for that court or by mail. Service of the Answer/Response to the opposing party may be by mail or if consented to by the opposing party by electronic service or fax. The Plaintiff or Cross-complainant can file a Request for Entry of Default on the 31st day after the complaint or cross-complaint has been personally served or service by Acknowledgment and Receipt is acknowledged by the answering party.  If the Answer/Response is not filed and accepted by the court before the opposing party obtains a Default, the court may reject the Answer/Response.  The Responding party must then file a "Motion to Set Aside the Default" along with their Answer (or another responding document such as a Demurrer and/or Motion to Strike) with the court and seek the court\'s permission to appear in the case.  In practice, courts rarely fail to grant a Motion to Set Aside Default judgments so it is generally a waste of time to file a Request for Entry of Default or insist on requiring that a responding party file a Motion to Set Aside the Default.  To do so may invite court sanctions.',
            'add_to' => 'dps',
            'subtract_delivery_days' => true,
        ]);
    }
}
