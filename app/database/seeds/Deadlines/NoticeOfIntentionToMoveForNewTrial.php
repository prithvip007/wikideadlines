<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class NoticeOfIntentionToMoveForNewTrial extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Notice of Intention to move for new trial'
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->deadlines()->create([
            'name' => 'A party must give notice of their intention to move for a new trial within 180 calendar days from the date the order or judgment was signed by the court.',
            'days' => 180,
            'days_type' => 'calendar',
            'add_to' => 'decr',
        ]);
    }
}
