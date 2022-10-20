<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class SanctionsDemand1287Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'CCP 128.7 Sanctions Demand Letter',
            'keywords' => '21-day safe harbor letter, Notice of Motion'
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->deadlines()->create([
            'name' => 'The sender must wait 21 calendar days after sending a CCP 128.7  Notice of Motion and Motion for Sanctions before they can file the CCP 128.7 Motion with the court. If the receiving party dismisses or modifies the offending portion of the complaint before the 21-day "safe harbor" period ends, then the sending party cannot then file the Motion for Sanctions.',
            'days' => 21,
            'days_type' => 'calendar',
            'add_to' => 'dps',
            'best_practices' => 'Any time during a case, if a party sees a potentially frivolous or harassing claim by an opposing party, they may initiate the CCP 128.7 sanctions demand procedure.',
            'subtract_delivery_days' => true,
        ]);
    }
}
