<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class ArbitrationAwardNotIssuedOrNotReceived extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Arbitration Award Not Issued or Not Received'
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->deadlines()->create([
            'name' => 'An arbitrator must issue an award within 10 calendar days of the conclusion of the arbitration (or 20 additional calendar days upon application by the arbitrator to the Superior Court asking for more time) CRC 3.825',
            'days' => 10,
            'days_type' => 'calendar',
            'add_to' => 'lad',
        ]);
    }
}
