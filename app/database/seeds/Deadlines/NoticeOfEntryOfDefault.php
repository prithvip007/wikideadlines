<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class NoticeOfEntryOfDefault extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Notice of Entry of Default',
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([1]);

        $document->deadlines()->create([
            'name' => 'A party must file a motion to set aside and vacate default judgment within 180 days after the entry of judgment. (CCP 663(a))',
            'days' => 180,
            'days_type' => 'calendar',
            'add_to' => 'je',
        ]);
    }
}
