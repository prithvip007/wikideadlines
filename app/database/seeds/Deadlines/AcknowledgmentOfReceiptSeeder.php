<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class AcknowledgmentOfReceiptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Acknowledgment of Receipt',
            'small_description' => 'An alternate method of service of process of a complaint/cross-complaint',
            'keywords' => 'Service, Process, by mail',
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->deadlines()->create([
            'name' => 'First date you can file a Request for Entry of Default if the party served by Acknowledgment of Receipt of Summons',
            'days' => 20,
            'days_type' => 'calendar',
            'best_practices' => 'When the party that has to be served lives out of state, papers can usually be served by sending a copy of the paperwork to be served to that party by first-class mail, postage prepaid, and return receipt requested. The person who mails the papers must be at least 18 and NOT a party to the case.',
            'add_to' => 'dps',
            'subtract_delivery_days' => true
        ]);
    }
}
