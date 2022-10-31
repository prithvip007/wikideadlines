<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class MotionForExtensionOfTimeToFileResponsivePleading extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Motion for extension of time to a file responsive pleading',
            'keywords' => 'Answer, more time, opposition, reply',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true,
            'days_before_hd_court' => 16
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([10]);

        $document->deadlines()->create([
            'name' => 'The parties may stipulate an additional fifteen (15)  days to serve a pleading responsive to a complaint or cross-complaint. Govt. Code § 68616(b), thirty (30) days if filed stipulation 68616(d). The parties may stipulate without leave of court to one (1) fifteen (15) day extension beyond the thirty (30) day time period prescribed for the response after service of the initial complaint. CRC 3.110(d). The court, on its own motion or on the application of a party, may extend or otherwise modify the times provided in California Rule of Court 3.110(b) through (d)(time to serve the complaint, cross-complaint or pleading responsive to an initial complaint)  Unless otherwise provided by law, the court may extend or shorten the time by which a party must perform any act under the California Rules of Court. CRC 1.10(c)',
            'days' => 30,
            'best_practices' => 'If the time needed to respond to complaint/cross-complaint request a fifteen (15) day extension by stipulation. Saves on filing ex parte or a full motion to with the court. The current reservation system forces an ex parte application to extend time.',
            'days_type' => 'calendar',
            'add_to' => 'dps',
            'subtract_delivery_days' => true,
        ]);
    }
}
