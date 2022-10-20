<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class NoticeOfJudgeAssignedAfterComplaintFiledOrDatePartyAppeared extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Notice of judge assigned after complaint filed or date party appeared (responded) (or judge reassigned)'
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->deadlines()->create([
            'name' => 'Deadline to disqualify an assigned judge',
            'days' => 15,
            'days_type' => 'calendar',
            'add_to' => 'dps',
        ]);
    }
}
