<?php

namespace Seeds;

use Illuminate\Database\Seeder;

class RequestsStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\RequestStatus::create([
            'id' => 1,
            'name' => 'Approved',
        ]);

        \App\Models\RequestStatus::create([
            'id' => 2,
            'name' => 'Rejected',
        ]);

        \App\Models\RequestStatus::create([
            'id' => 3,
            'name' => 'Needs further review',
        ]);
    }
}
