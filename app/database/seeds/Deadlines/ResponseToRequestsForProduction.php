<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class ResponseToRequestsForProduction extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Response to Requests for Production'
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([3, 6, 7]);

        $document->deadlines()->create([
            'name' => 'Last date to file and serve a Motion to Compel Discovery Responses for this item of Discovery',
            'days' => 45,
            'best_practices' => 'Note: Discovery responses must now include the discovery request number that the party is responding to for each discovery response.   Also, if you don\'t get any response (a served, formal response, verified by the responding party) to a particular discovery document sent, the 45-day limit of time to file a Motion to Compel does not start running.   If you are the propounding party, it is recommended that you begin the meet and confer process at least 25 days before the 45-day rule deadline.   In addition, get a written confirmation with a specified date, to extend your 45-day deadline - at least 15 calendar days before the 45-day rule deadline.',
            'days_type' => 'calendar',
            'add_to' => 'dps',
        ]);

        $document->deadlines()->create([
            'name' => 'Last date for the party that sent the discovery to initiate Meet and Confer discussions.',
            'days' => 40,
            'days_type' => 'calendar',
            'add_to' => 'dps',
        ]);
    }
}
