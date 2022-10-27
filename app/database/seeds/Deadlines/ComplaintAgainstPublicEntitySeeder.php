<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class ComplaintAgainstPublicEntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Complaint against a public entity',
            'small_description' => 'i.e. against a city, county, state or federal government or an entity funded by a government entity'
        ]);

        $document->deliveryMethods()->sync([6]);

        $document->dateQuestions()->sync([1]);

        $document->deadlines()->create([
            'name' => 'Deadline to bring a case to trial',
            'days' => 1825,
            'days_type' => 'calendar',
            'add_to' => 'dcf',
        ]);
    }
}
