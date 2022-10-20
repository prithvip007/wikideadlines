<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class ArbitrationAward extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Arbitration Award'
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->deadlines()->create([
            'name' => 'Within 60 calendar days of service of the arbitration award, a party must file any rejection of the award.  CRC 3.826',
            'days' => 60,
            'days_type' => 'calendar',
            'add_to' => 'dps',
            'subtract_delivery_days' => true,
        ]);
    }
}
