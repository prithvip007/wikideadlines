<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class MemorandumOfCosts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Memorandum of Costs',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([8]);

        $document->deadlines()->create([
            'name' => 'Before the judgment is fully satisfied but not later than two years after the costs have been incurred.   You can file the Memorandum of Costs later than every two years - but you then cannot include any costs or fees the period since the judgment or last memorandum of costs filing date. (CCP 685.070)',
            'days' => 730,
            'best_practices' => 'To claim costs after judgment must file a Memorandum of Costs (Cal. Judicial form MC-012) every two years after the date of judgment',
            'days_type' => 'calendar',
            'add_to' => 'dps',
        ]);

        $document->deadlines()->create([
            'name' => 'A prevailing party who claims costs must serve and file a memorandum of costs within 15 calendar days after the date of service of the notice of entry of judgment or dismissal by the clerk under Code of Civil Procedure section 664.5 or the date of service of written notice of entry of judgment or dismissal, or within 180 days after entry of judgment, whichever is first. The memorandum of costs must be verified by a statement of the party, attorney, or agent that to the best of his or her knowledge the items of cost are correct and were necessarily incurred in the case.',
            'days' => 15,
            'best_practices' => 'The deadline for service of a memorandum of costs after judgment is after the court clerk or the party filing the memorandum mails notice of entry of judgment (CRC Rule 3.1700) There is case law indicating that the 15 days may be extended by the type of service.',
            'days_type' => 'calendar',
            'add_to' => 'decr',
        ]);
    }
}
