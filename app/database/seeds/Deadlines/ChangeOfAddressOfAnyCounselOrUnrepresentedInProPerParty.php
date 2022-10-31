<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class ChangeOfAddressOfAnyCounselOrUnrepresentedInProPerParty extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Change of address of any counsel or unrepresented in pro per party',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([1]);

        $document->deadlines()->create([
            'name' => 'There is no deadline, however, you risk having notices from the court in any pending case sending a notice to your prior mailing address.',
            'days' => 0,
            'days_type' => 'calendar',
            'add_to' => 'dps',
        ]);
    }
}
