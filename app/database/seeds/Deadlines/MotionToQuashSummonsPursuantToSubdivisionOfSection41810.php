<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class MotionToQuashSummonsPursuantToSubdivisionOfSection41810 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Motion to Quash Summons pursuant to subdivision (b) of Section 418.10.'
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([1]);

        $document->deadlines()->create([
            'name' => 'Motion to Quash Summons Must be filed by Date to Respond to Complaint (CCP 418.10)',
            'days' => 0,
            'best_practices' => 'Use same Motion Schedule as CCP 1005',
            'days_type' => 'calendar',
            'add_to' => 'drc',
        ]);
    }
}
