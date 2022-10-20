<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class MotionForOrderShorteningTimeToServeMotion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Motion for order shortening time to serve a motion',
            'keywords' => 'Ex Parte, opposition, reply',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true,
            'days_before_hd_court' => 16
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([1, 10]);

        $document->deadlines()->create([
            'name' => 'Cal. Rules of Cout rule 3.100(b) Order shortening time The court, on its own motion or on an application for an order shortening time supported by a declaration showing good cause, may prescribe shorter times for the filing and service of papers than the times specified in Code of Civil Procedure section 1005.',
            'days' => -1,
            'days_type' => 'court',
            'best_practices' => 'Best to inquire if the opposing party will grant a stipulation to shorter time. Per Cal. Rules of Ct 3.1300 the application for an order shortening time must be supported by an affidavit or declaration showing good cause. (You’ll need to show that the moving party would suffer some substantial prejudice or harm if the underlying motion is not heard sooner.) The order shortening time should address: (1) when the motion papers are to be served, (2) when the opposition papers are due, (3) when the reply papers are due, (4) how papers are to be served (e.g., by hand delivery), and (5) the date of the hearing.',
            'add_to' => 'exph',
            'calculate_if_same_judge' => true,
        ]);
    }
}
