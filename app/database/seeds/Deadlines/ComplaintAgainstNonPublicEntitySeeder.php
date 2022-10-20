<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class ComplaintAgainstNonPublicEntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Complaint against a person or non-public entity',
            'small_description' => 'i.e. not against a city, county, state or federal government or an entity funded by a government entity',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true,
        ]);

        $document->deliveryMethods()->sync([6]);

        $document->dateQuestions()->sync([1]);

        $document->deadlines()->create([
            'name' => '5-years, after the case was filed, is the deadline for the plaintiff to have the case "brought to trial" - i.e. to have the trial started (opening statements began in a bench trial or jury selection started if a jury trial) after which the case is automatically dismissed with prejudice. [CCP 583.310]',
            'days' => 1825,
            'days_type' => 'calendar',
            'add_to' => 'dcf',
        ]);

        $document->deadlines()->create([
            'name' => 'Plaintiff or Cross-Complainant must file the Proof of Service of Summons and Complaint within 60 days of filing the complaint.  CRC 3.110.  See also  CCP § 583.210 which requires filing the Proof of Service within 60 days after serving the complaint.  ',
            'days' => 60,
            'best_practices' => 'Due to the conflict between the Code of Civil Procedure and the Rules of Court, the best practice is to use the shorter time limit.',
            'days_type' => 'calendar',
            'add_to' => 'dcf',
        ]);

        $document->deadlines()->create([
            'name' => 'First date plaintiff can file a Request for Entry of Default with the court if no Answer, cross-complaint, motion to strike and/or demurrer has been filed by the defendant.',
            'days' => 31,
            'days_type' => 'calendar',
            'add_to' => 'dsococcic',
        ]);

        $document->deadlines()->create([
            'name' => 'Last date to respond to the complaint without an extension (30 days from service).   A response can be an Answer, a cross-complaint, a Motion to Strike (all or parts of the complaint), and/or a Demurrer.',
            'days' => 30,
            'best_practices' => 'It is highly recommended you get any extensions in writing.   An email from opposing counsel is sufficient - even if you\'ve not yet stipulated to service via email.',
            'days_type' => 'calendar',
            'add_to' => 'dsococcic',
        ]);

        $document->deadlines()->create([
            'name' => 'First date plaintiff can serve discovery on the party served with the complaint.',
            'days' => 10,
            'days_type' => 'calendar',
            'add_to' => 'dsococcic',
        ]);
    }
}
