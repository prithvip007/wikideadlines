<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class NoticeOfApplicationAndHearingForClaimAndDeliveryUnderSection512030 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Notice of Application and Hearing for Claim and Delivery under Section 512.030.',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->deadlines()->create([
            'name' => '512.020.  (a) Except as otherwise provided in this section, no writ shall be issued under this chapter except after a hearing on a noticed motion.       512.030(a) Prior to the hearing required by subdivision (a) of Section 512.020, the defendant shall be served with all of the following:                                                                                                            (1) A copy of the summons and complaint.
(2) A Notice of Application and Hearing.
(3) A copy of the application and any affidavit in support thereof.
(b) If the defendant has not appeared in the action, and a writ, notice, order, or other paper is required to be personally served on the defendant under this title, service shall be made in the same manner as a summons is served under Chapter 4 (commencing with Section 413.10) of Title 5.',
            'days' => -16,
            'days_type' => 'court',
            'add_to' => 'hd',
        ]);

        $document->deadlines()->create([
            'name' => 'Opposition must be filed with the court 9 court days before the first hearing date set and served on the opposing side no less than one business day after it is filed with the court.',
            'days' => -9,
            'days_type' => 'court',
            'add_to' => 'hd',
        ]);

        $document->deadlines()->create([
            'name' => 'A reply must be filed with the court 5 court days before the first hearing date set and served on the opposing side no less than one business day after it is filed with the court.',
            'days' => -5,
            'days_type' => 'court',
            'add_to' => 'hd',
        ]);
    }
}
