<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class MotionToStrikeCosts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Motion to strike costs',
            'keywords' => 'opposition, reply motionToStrikeCost',
            'days_before_hd_court' => 16
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([10]);

        $document->deadlines()->create([
            'name' => 'Any notice of motion to strike or to tax costs must be served and filed 15 days after service of the cost memorandum. If the cost memorandum was served by mail, the period is extended as provided in Code of Civil Procedure section 1013. If the cost memorandum was served electronically, the period is extended as provided in Code of Civil Procedure section 1010.6(a)(4) - (CRC 3.1700)',
            'days' => 15,
            'days_type' => 'calendar',
            'add_to' => 'dmocs',
        ]);
    }
}
