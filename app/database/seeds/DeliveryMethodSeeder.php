<?php

namespace Seeds;

use Illuminate\Database\Seeder;

class DeliveryMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\DeliveryMethod::create([
        //     'id' => 1,
        //     'name' => 'Regular Mail',
        //     'days' => 5,
        //     'reference_key' => 'regular_mail',
        //     'days_type' => 'calendar',
        //     'outside_country_days' => 20,
        //     'outside_state_days' => 10,
        // ]);

        // \App\Models\DeliveryMethod::create([
        //     'id' => 2,
        //     'name' => 'Overnight Delivery',
        //     'reference_key' => 'overnight_mail',
        //     'description' => 'FedEx, UPS, US Post Express Mail',
        //     'days' => 2,
        //     'days_type' => 'court',
        //     'preselected' => true
        // ]);

        // \App\Models\DeliveryMethod::create([
        //     'id' => 3,
        //     'name' => 'Email',
        //     'reference_key' => 'email',
        //     'description' => 'If party receiving service has consented to e-service, or, if under the Emergency COVID-19 rule, the receiving party has requested by email, to be served electronically',
        //     'days' => 0,
        //     'days_type' => 'court',
        //     'warning' => 'A party can only serve a document by fax, email, or eservice if they have a signed stipulation with the receiving party agreeing to accept the method of electronic service, a court order regarding eservice or the parties have utilized an electronic filing service provider (EFSP) and agreed to the terms of consent for eservice via the EFSP.'
        // ]);

        // \App\Models\DeliveryMethod::create([
        //     'id' => 4,
        //     'name' => 'Fax',
        //     'reference_key' => 'fax',
        //     'days' => 2,
        //     'days_type' => 'court',
        //     'warning' => 'A party can only serve a document by fax, email, or eservice if they have a signed stipulation with the receiving party agreeing to accept the method of electronic service, a court order regarding eservice or the parties have utilized an electronic filing service provider (EFSP) and agreed to the terms of consent for eservice via the EFSP.'
        // ]);

        // \App\Models\DeliveryMethod::create([
        //     'id' => 5,
        //     'name' => 'Hand Delivery',
        //     'reference_key' => 'hand_delivery',
        //     'days' => 0,
        //     'days_type' => 'calendar'
        // ]);

        // \App\Models\DeliveryMethod::create([
        //     'id' => 6,
        //     'name' => 'Personal Service',
        //     'reference_key' => 'personal_service',
        //     'days' => 0,
        //     'days_type' => 'calendar'
        // ]);

        // \App\Models\DeliveryMethod::create([
        //     'id' => 7,
        //     'name' => 'E-Filing Service (OneLegal, etc.)',
        //     'reference_key' => 'e_filing',
        //     'days' => 0,
        //     'days_type' => 'court'
        // ]);

        // # https://app.asana.com/0/0/1202358165649662/1202671907737351/f
        // \App\Models\DeliveryMethod::create([
        //     'id' => 8,
        //     'name' => 'Certified mail',
        //     'reference_key' => 'certified_mail',
        //     'days' => 5,
        //     'days_type' => 'calendar'
        // ]);

        // // 
        // \App\Models\DeliveryMethod::create([
        //     'id' => 1,
        //     'name' => 'Service of Summons by First Class Mail and Acknowledgement of Receipt of Summons',
        //     'days' => 5,
        //     'reference_key' => 'acknowledgement',
        //     'days_type' => 'calendar',
        //     'outside_country_days' => 20,
        //     'outside_state_days' => 10,
        // ]);
    }
}
