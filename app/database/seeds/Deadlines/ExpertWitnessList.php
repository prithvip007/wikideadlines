<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class ExpertWitnessList extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Expert Witness List',
            'keywords' => 'Simultaneous Exchange'
        ]);

        $document->dateQuestions()->sync([1]);

        $document->deadlines()->create([
            'name' => 'Expert Demand. You must make your demand no later than the 10th day after the initial trial date is set, or 70 days before the trial date, whichever is closer to the trial date. If that day falls on a Saturday, Sunday or court holiday, the last day to make your demand is the next court day closer to the trial date (CCP § 2034.220).',
            'days' => -70,
            'days_type' => 'calendar',
            'add_to' => 'td',
        ]);
    }
}
