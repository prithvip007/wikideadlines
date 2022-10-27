<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class WritOfMandateAfterMotionForDeterminationOfGoodFaithSettlementPursuantToSection8776 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Writ of Mandate after Motion for Determination of Good Faith Settlement pursuant to Section 877.6.'
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->deadlines()->create([
            'name' => 'When a determination of the good faith or lack of good faith of a settlement is made, any party aggrieved by the determination may petition the proper court to review the determination by writ of mandate. The petition for writ of mandate shall be filed within 20 days after service of written notice of the determination, or within any additional time not exceeding 20 days as the trial court may allow.',
            'days' => 20,
            'days_type' => 'calendar',
            'add_to' => 'dps',
        ]);
    }
}
