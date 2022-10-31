<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class MotionToVacateJudgmentCCP663aOpposition extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Motion to Vacate Judgment CCP 663a [Opposition]',
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->deadlines()->create([
            'name' => 'Within 10 days of filing the notice, the moving party shall serve upon all other parties and file any brief and accompanying documents, including affidavits in support of the motion.  The other parties shall have 10 days after that service within which to serve upon the moving party and file any opposing briefs and accompanying documents, including counter-affidavits.  The moving party shall have five days after that service to file any reply brief and accompanying documents.  These deadlines may, for good cause shown by affidavit or by written stipulation of the parties, be extended by any judge for an additional period not to exceed 10 days.',
            'days' => 10,
            'days_type' => 'calendar',
            'add_to' => 'dps',
            'subtract_delivery_days' => true,
        ]);
    }
}
