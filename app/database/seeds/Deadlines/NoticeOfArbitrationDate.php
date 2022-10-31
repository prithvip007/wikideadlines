<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class NoticeOfArbitrationDate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Notice of Arbitration Date'
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);
    
        $document->dateQuestions()->sync([1, 7]);

        $document->deadlines()->create([
            'name' => 'Discovery closes 15 calendar days before the arbitration hearing. CRC 3.822',
            'days' => -15,
            'days_type' => 'calendar',
            'add_to' => 'afhd',
        ]);
    }
}
