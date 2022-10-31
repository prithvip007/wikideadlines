<?php

namespace Seeds\Deadlines;

use Illuminate\Database\Seeder;

class ExParteMotion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Models\DocumentType::create([
            'name' => 'Ex Parte Motion',
            'keywords' => 'opposition, reply',
            'ask_hearing_courthouse' => true,
            'ask_hearing_courtroom' => true
        ]);

        $document->deliveryMethods()->sync([1, 2, 3, 4, 5]);

        $document->dateQuestions()->sync([1]);

        $document->deadlines()->create([
            'name' => 'A party seeking an ex parte order must notify all parties no later than 10:00 a.m. the court day before the ex parte appearance, and must directly file with the courtroom (typically by 11 a.m. one court day before the ex parte hearing) a copy of (sometimes two copies) all the moving papers (absent a showing of exceptional circumstances that justify a shorter time for notice, or no that no notice be given)',
            'days' => 1,
            'days_type' => 'court',
            'best_practices' => 'Always check local Rules and the trial department Rules before drafting the Ex Parte Notice and Motion. State with specificity the nature of the relief to be requested and the date, time, and place for the presentation of the application; and attempt to determine whether the opposing party will appear to oppose the application.
            The ex parte papers filed with the court must include:
            1. An application containing the case caption, the relief requested, a disclosure of previously refused applications, and the name, address, e-mail, and phone number of any attorney or unrepresented party.
            2. A declaration in support of the application, based on personal knowledge, that ex parte relief is needed to prevent irreparable harm, immediate danger, or any other statutory basis for granting relief ex parte:
            3. A declaration based on personal knowledge of the notice given.
            4. A memorandum.
            5. A proposed order.
            From date/time of notice which can be by phone call, fax, or hand delivery only, unless there is a signed stipulation for electronic delivery in place - then an emailed notice is also acceptable.',
            'add_to' => 'hd',
            'subtract_delivery_days' => true,
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
