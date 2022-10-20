<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class NoticeOfTrustAdministration extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Notice of Trust Administration'
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->deadlines()->create([
            'name' => 'Trust contests generally must be filed within 120 days of transmittal of a notice of trust administration under California Probate Code section 16061.7.',
            'days' => 120,
            'days_type' => 'calendar',
            'add_to' => 'dps',
        ]);
    }
}
