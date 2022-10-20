<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class Answer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Answer',
            'keywords' => 'Response, Demurrer, Strike, Sanctions, 128.7, Quash, Extension, Cross-Complaint, Reply, Discovery, Pleading'
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->deadlines()->create([
            'name' => 'A Motion for Summary Judgment can be filed 60 days after a party against whom the motion is directed first appears in an action but no later than 30 days before trial. The SJ hearing can be no sooner than 75 after service of the notice of motion. The cited days can be shortened for good cause by court order.',
            'days' => -30,
            'days_type' => 'calendar',
            'add_to' => 'dps',
            'subtract_delivery_days' => true,
        ]);
    }
}
