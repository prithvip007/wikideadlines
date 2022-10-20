<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class Complaint extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Complaint'
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->deadlines()->create([
            'name' => 'The parties shall meet and confer at least five calendar days before the date the demurrer is filed.  If the parties are not able to meet and confer at least five days prior to the date any responsive pleading is due, including a demurrer, motion to strike, motion to quash or answer; the demurring party shall be granted an automatic 30-day extension of time within which to file any responsive pleading, by filing and serving, on or before the date on which a demurrer would be due, a declaration stating under penalty of perjury that a good faith attempt to meet and confer was made and explaining the reasons why the parties could not meet and confer.',
            'days' => 25,
            'days_type' => 'calendar',
            'add_to' => 'dps',
            'subtract_delivery_days' => true,
        ]);
    }
}
