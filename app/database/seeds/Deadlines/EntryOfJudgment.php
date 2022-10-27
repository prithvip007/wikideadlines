<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class EntryOfJudgment extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Entry of Judgment'
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->deadlines()->create([
            'name' => 'Unless a statute or rules 8.108, 8.702, or 8.712 provides otherwise, a notice of appeal must be filed on or before the earliest of:
                (A)  60 days after the superior court clerk serves on the party filing the notice of appeal a document entitled "Notice of Entry" of judgment or a filed-endorsed copy of the judgment, showing the date either was served;
                (B)  60 days after the party filing the notice of appeal serves or is served by a party with a document entitled "Notice of Entry" of judgment or a filed-endorsed copy of the judgment, accompanied by proof of service; or
                (C)  180 days after entry of judgment.
                (2)  Service under (1)(A) and (B) may be by any method permitted by the Code of Civil Procedure, including electronic service when permitted under Code of Civil Procedure section 1010.6 and rules 2.250-2.261.
                (3)  If the parties stipulated in the trial court under Code of Civil Procedure section 1019.5 to waive notice of the court order being appealed, the time to appeal under (1)(C) applies unless the court or a party serves notice of entry of judgment or a filed-endorsed copy of the judgment to start the time period under (1)(A) or (B)."',
            'days' => 60,
            'days_type' => 'calendar',
            'add_to' => 'decr',
        ]);

        $document->deadlines()->create([
            'name' => 'Unless a statute or rules 8.108, 8.702, or 8.712 provides otherwise, a notice of appeal must be filed on or before the earliest of:
                (A)  60 days after the superior court clerk serves on the party filing the notice of appeal a document entitled "Notice of Entry" of judgment or a filed-endorsed copy of the judgment, showing the date either was served;
                (B)  60 days after the party filing the notice of appeal serves or is served by a party with a document entitled "Notice of Entry" of judgment or a filed-endorsed copy of the judgment, accompanied by proof of service; or
                (C)  180 days after entry of judgment.
                (2)  Service under (1)(A) and (B) may be by any method permitted by the Code of Civil Procedure, including electronic service when permitted under Code of Civil Procedure section 1010.6 and rules 2.250-2.261.
                (3)  If the parties stipulated in the trial court under Code of Civil Procedure section 1019.5 to waive notice of the court order being appealed, the time to appeal under (1)(C) applies unless the court or a party serves notice of entry of judgment or a filed-endorsed copy of the judgment to start the time period under (1)(A) or (B).',
            'days' => 180,
            'days_type' => 'calendar',
            'best_practices' => 'Refer to CRC 8.104 for clarity',
            'add_to' => 'decr',
        ]);
    }
}
