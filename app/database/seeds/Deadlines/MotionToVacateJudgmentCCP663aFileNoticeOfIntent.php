<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class MotionToVacateJudgmentCCP663aFileNoticeOfIntent extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Motion to Vacate Judgment CCP 663a [File Notice of Intent]',
            'keywords' => 'opposition, reply',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true,
            'days_before_hd_court' => 16
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([10]);

        $document->deadlines()->create([
            'name' => 'Within 10 days of filing the notice, the moving party shall serve upon all other parties and file any brief and accompanying documents, including affidavits in support of the motion.  The other parties shall have 10 days after that service within which to serve upon the moving party and file any opposing briefs and accompanying documents, including counter-affidavits.  The moving party shall have five days after that service to file any reply brief and accompanying documents.  These deadlines may, for good cause shown by affidavit or by written stipulation of the parties, be extended by any judge for an additional period not to exceed 10 days.',
            'days' => 10,
            'days_type' => 'calendar',
            'add_to' => 'dps',
        ]);

        $document->deadlines()->create([
            'name' => 'Within 15 days of the date of mailing of a notice of entry of judgment by the clerk of the court pursuant to Section 664.5, or service upon him or her by any party of written notice of entry of judgment, or within 180 days after the entry of judgment, whichever is earliest.',
            'days' => 15,
            'best_practices' => 'Must file Notice of Intent to Vacate within 15 days of the MAILING of the notice of entry of the judgment.',
            'days_type' => 'calendar',
            'add_to' => 'monoeojd',
        ]);

        $document->deadlines()->create([
            'name' => 'Within 15 days of the date of mailing of a notice of entry of judgment by the clerk of the court pursuant to Section 664.5, or service upon him or her by any party of written notice of entry of judgment, or within 180 days after the entry of judgment, whichever is earliest.',
            'days' => 180,
            'best_practices' => 'Ruling on a motion must take place within 75 days of mailing notice of entry of judgment or filing notice of intent if no mailing of the notice.',
            'days_type' => 'calendar',
            'add_to' => 'je',
        ]);

        $document->deadlines()->create([
            'name' => 'A party intending to make a motion to set aside and vacate a judgment, as described in Section 663 , shall file with the clerk and serve upon the adverse party a notice of his or her intention, designating the grounds upon which the motion will be made, and specifying the particulars in which the legal basis for the decision is not consistent with or supported by the facts, or in which the judgment or decree is not consistent with the special verdict',
            'days' => 75,
            'best_practices' => 'Except as otherwise provided in Section 12a, the power of the court to rule on a motion to set aside and vacate a judgment shall expire 75 days from the mailing of notice of entry of judgment by the clerk of the court pursuant to Section 664.5, or 75 days after service upon the moving party by any party of written notice of entry of the judgment, whichever is earlier, or if that notice has not been given, 75 days after the filing of the first notice of intention to move to set aside and vacate the judgment. If that motion is not determined within the 75-day period, or within that period as extended, the effect shall be a denial of the motion without further order of the court. Note: ccp 1013 does not apply to extend the 15 days to file the notice of intent after the clerk mails the notice of entry of the judgment.',
            'days_type' => 'calendar',
            'add_to' => 'dps',
        ]);
    }
}
