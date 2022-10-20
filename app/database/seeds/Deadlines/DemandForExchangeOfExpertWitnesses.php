<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class DemandForExchangeOfExpertWitnesses extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Demand for Exchange of Expert Witnesses',
            'keywords' => 'Demand Disclosure Expert Witnesses trial, Supplemental Disclosure'
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->deadlines()->create([
            'name' => 'Demand for Exchange of Expert Witnesses - Experts Must Be Demanded – 70 days before trial (or within 10 days of setting a trial date, whichever is closer to trial date) [CCP 2034.220]',
            'days' => -70,
            'days_type' => 'calendar',
            'add_to' => 'td',
        ]);

        $document->deadlines()->create([
            'name' => 'Date of exchange. Lists must be exchanged 50 days before the trial date, or 20 days after service of the demand, whichever is closer to the trial date. If that day falls on a Saturday, Sunday or court holiday, the last day to provide your list is the next court day closer to the trial date (CCP § 2034.230(b)), unless the court orders an earlier or later exchange.',
            'days' => -20,
            'days_type' => 'calendar',
            'add_to' => 'dod',
        ]);

        $document->deadlines()->create([
            'name' => 'Demand for Disclosure of Expert Witnesses to be used at trial - Experts Must Be Disclosed – 50 days before trial (or 20 days after service of demand, whichever is closer to trial date) [CCP 2034.230]',
            'days' => -50,
            'days_type' => 'calendar',
            'add_to' => 'td',
        ]);

        $document->deadlines()->create([
            'name' => 'Expert Discovery Cut Off – 15 days before original trial date. [CCP 2024.030]',
            'days' => -15,
            'days_type' => 'calendar',
            'add_to' => 'ftds',
        ]);

        $document->deadlines()->create([
            'name' => 'Last Day for Motions Regarding Experts – 10 days before original trial date.  [CCP 2024.030]',
            'days' => -10,
            'days_type' => 'calendar',
            'add_to' => 'ftds',
        ]);

        $document->deadlines()->create([
            'name' => 'Expert Depositions – May be set “On receipt of an expert witness list from a party.”  [CCP 2034.410]',
            'days' => 0,
            'days_type' => 'calendar',
            'add_to' => 'dps',
            'subtract_delivery_days' => true,
        ]);


        $document->deadlines()->create([
            'name' => 'Supplemental Expert Disclosure - Supplemental Expert Disclosure – Must be disclosed within 20 days of the Exchange of Expert Witnesses.  May only disclose witness to cover a subject covered by opponent’s witnesses.  [CCP 2034.280]',
            'days' => 20,
            'days_type' => 'calendar',
            'add_to' => 'dps',
        ]);
    }
}
