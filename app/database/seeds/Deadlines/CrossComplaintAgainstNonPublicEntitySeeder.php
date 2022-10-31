<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class CrossComplaintAgainstNonPublicEntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Cross-Complaint against a person or non-public entity',
            'small_description' => 'i.e. not against a city, county, state or federal government or an entity funded by a government entity',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true
        ]);

        $document->deliveryMethods()->sync([6]);

        $document->dateQuestions()->sync([1]);

        $document->deadlines()->create([
            'name' => 'Deadline to bring a case to trial',
            'days' => 1825,
            'days_type' => 'calendar',
            'add_to' => 'dcf',
        ]);

        $document->deadlines()->create([
            'name' => 'Plaintiff or Cross-Complainant must file the Proof of Service of Summons and Complaint within 60 days of filing the complaint.  CRC 3.110.  See also  CCP § 583.210 which requires filing the Proof of Service within 60 days after serving the complaint.  ',
            'days' => 60,
            'days_type' => 'calendar',
            'add_to' => 'dcf',
        ]);

        $document->deadlines()->create([
            'name' => 'First date you can file a Request for Entry of Default',
            'days' => 31,
            'days_type' => 'calendar',
            'add_to' => 'dsococcic',
            'subtract_delivery_days' => true,
        ]);

        $document->deadlines()->create([
            'name' => 'Last date to respond to a complaint without an extension (30 days from service). A response can be an Answer, a cross-complaint, a Motion to Strike (all or parts of the complaint), and/or a Demurrer.',
            'days' => 30,
            'days_type' => 'calendar',
            'best_practices' => 'It is highly recommended you get any extensions in writing. An email from opposing counsel is sufficient - even if you\'ve not yet stipulated to service via email.',
            'add_to' => 'dsococcic',
            'subtract_delivery_days' => true,
        ]);

        $document->deadlines()->create([
            'name' => 'First date you can serve discovery on a party who has been served with the complaint.',
            'days' => 11,
            'days_type' => 'calendar',
            'add_to' => 'dsococcic',
            'subtract_delivery_days' => true,
        ]);
    }
}
