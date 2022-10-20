<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class Discovery extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Discovery',
            'keywords' => 'Written, propound',
            'small_description' => 'Such as Form Interrogatories, Special Interrogatories, Request for Production, Request for Admissions, Request for Genuiness of Documents'
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([3, 6, 7]);

        $document->deadlines()->create([
            'name' => 'Deadline to respond to written discovery is 30 days plus time for service method used.',
            'days' => 30,
            'days_type' => 'calendar',
            'best_practices' => 'CCP 2030.260 requires that discovery be responded to within 30 calendar days of service. However, it is common to request and be granted an extension of time to respond (although do so well prior to the response deadline) and to be granted anywhere from 1 week to 4 weeks. You\'ll need to get that extension in writing from the opposing counsel/party.  If you are granting the extension - make sure the grant includes the phrase "This will also extend the 45-day rule to" [insert exact date].',
            'add_to' => 'dps',
            'subtract_delivery_days' => true,
        ]);
    }
}
