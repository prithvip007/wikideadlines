<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class NoticeOfDepositionOfExpert extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Notice of Deposition of Expert',
            'keywords' => 'Expert Documents Deposition'
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([1, 6, 7]);

        $document->deadlines()->create([
            'name' => 'Experts Must Provide Documents Before Their Depo – 3 business days before a deposition, experts must provide a copy of the documents that they are producing in response to the deposition notice.  [CCP 2034.415]',
            'days' => -3,
            'days_type' => 'court',
            'add_to' => 'dd',
        ]);
    }
}
