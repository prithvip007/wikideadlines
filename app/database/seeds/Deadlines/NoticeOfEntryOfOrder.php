<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class NoticeOfEntryOfOrder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Notice of Entry of Order',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([2]);

        $document->deadlines()->create([
            'name' => 'Deadline to file a writ challenging any order - although it is recommended writs be filed within 5 court days after notice of entry of an order 2020 California Rules of Court Rule 8.104. Time to appeal',
            'days' => 60,
            'days_type' => 'calendar',
            'add_to' => 'dcf',
        ]);

        $document->deadlines()->create([
            'name' => 'Any party affected by a trial court\'s order can ask, within 10 calendar days, the same court to reconsider the order, based on new facts, circumstances, or law. You must file a Motion for Reconsideration within 10 calendar days of being served with the written notice of entry of the order you want the court to reconsider.',
            'days' => 10,
            'days_type' => 'calendar',
            'add_to' => 'dps',
        ]);

        $document->deadlines()->create([
            'name' => 'L/D to serve by messenger/hand delivery',
            'days' => 0,
            'days_type' => 'calendar',
            'add_to' => 'hand_delivery',
        ]);

        $document->deadlines()->create([
            'name' => 'L/D to serve by eFile, OneLegal, or email',
            'days' => 0,
            'days_type' => 'calendar',
            'add_to' => 'electronic',
        ]);

        $document->deadlines()->create([
            'name' => 'L/D to serve by fax, or overnight delivery.',
            'days' => -2,
            'days_type' => 'calendar',
            'add_to' => 'email',
        ]);

        $document->deadlines()->create([
            'name' => ' L/D to serve by regular mail from within the State',
            'days' => -5,
            'days_type' => 'calendar',
            'add_to' => 'regular_mail_within_state',
        ]);

        $document->deadlines()->create([
            'name' => 'L/D to serve by regular mail from outside the State but inside the United States.',
            'days' => -10,
            'days_type' => 'calendar',
            'add_to' => 'regular_mail_outside_state',
        ]);

        $document->deadlines()->create([
            'name' => 'L/D to serve by regular mail from outside the United States.',
            'days' => -20,
            'days_type' => 'calendar',
            'add_to' => 'regular_mail_outside_country',
        ]);
    }
}
