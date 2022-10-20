<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class MotionForJudgmentOnThePleadings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Motion for Judgment on the Pleadings',
            'keywords' => 'opposition, reply',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true,
            'days_before_hd_court' => 16
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([1, 10, 5, 7]);

        $document->deadlines()->create([
            'name' => '(c) (1) The motion provided for in this section may only be made on one of the following grounds:

                (A) If the moving party is a plaintiff, that the complaint states facts sufficient to constitute a cause or causes of action against the defendant and the answer does not state facts sufficient to constitute a defense to the complaint.
                
                (B) If the moving party is a defendant, that either of the following conditions exist:
                
                (i) The court has no jurisdiction of the subject of the cause of action alleged in the complaint.
                
                (ii) The complaint does not state facts sufficient to constitute a cause of action against that defendant.                                                                                   (d) The grounds for motion provided for in this section shall appear on the face of the challenged pleading or from any matter of which the court is required to take judicial notice. Where the motion is based on a matter of which the court may take judicial notice pursuant to Section 452 or 453 of the Evidence Code, the matter shall be specified in the notice of motion, or in the supporting points and authorities, except as the court may otherwise permit.                                        (e) No motion may be made pursuant to this section if a pretrial conference order has been entered pursuant to Section 575, or within 30 days of the date, the action is initially set for trial, whichever is later, unless the court otherwise permits.
                
                (f) The motion provided for in this section may be made only after one of the following conditions has occurred:
                
                (1) If the moving party is a plaintiff, and the defendant has already filed his or her answer to the complaint and the time for the plaintiff to demur to the answer has expired.
                
                (2) If the moving party is a defendant, and the defendant has already filed his or her answer to the complaint and the time for the defendant to demur to the complaint has expired.',
            'days' => 30,
            'days_type' => 'court',
            'add_to' => 'ftds',
        ]);

        $document->deadlines()->create([
            'name' => '(c) (1) The motion provided for in this section may only be made on one of the following grounds:

                (A) If the moving party is a plaintiff, that the complaint states facts sufficient to constitute a cause or causes of action against the defendant and the answer does not state facts sufficient to constitute a defense to the complaint.
                
                (B) If the moving party is a defendant, that either of the following conditions exist:
                
                (i) The court has no jurisdiction of the subject of the cause of action alleged in the complaint.
                
                (ii) The complaint does not state facts sufficient to constitute a cause of action against that defendant.                                                                                   (d) The grounds for motion provided for in this section shall appear on the face of the challenged pleading or from any matter of which the court is required to take judicial notice. Where the motion is based on a matter of which the court may take judicial notice pursuant to Section 452 or 453 of the Evidence Code, the matter shall be specified in the notice of motion, or in the supporting points and authorities, except as the court may otherwise permit.                                        (e) No motion may be made pursuant to this section if a pretrial conference order has been entered pursuant to Section 575, or within 30 days of the date, the action is initially set for trial, whichever is later, unless the court otherwise permits.
                
                (f) The motion provided for in this section may be made only after one of the following conditions has occurred:
                
                (1) If the moving party is a plaintiff, and the defendant has already filed his or her answer to the complaint and the time for the plaintiff to demur to the answer has expired.
                
                (2) If the moving party is a defendant, and the defendant has already filed his or her answer to the complaint and the time for the defendant to demur to the complaint has expired.',
            'days' => -16,
            'days_type' => 'court',
            'best_practices' => 'Like a demurrer, the grounds for a motion for judgment on the pleadings must appear on the face of the challenged pleading or matters of which the Court can take judicial notice. The judge hearing the motion cannot consider discovery admissions or other evidence controverting the pleadings. . . . If you need to controvert material fact in the pleading, the proper vehicle is a motion for summary judgment rather than one for judgment on the pleadings. . . Cal. Prac. Guide Civ. Pro. Before Trial 7:322 (Rutter Group 2016).',
            'add_to' => 'ftds',
            'subtract_delivery_days' => true,
        ]);
    }
}
