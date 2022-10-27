<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFscTriggeringEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE deadlines DROP CONSTRAINT available_event_triggers_check_v10');

        DB::statement("ALTER TABLE deadlines ADD CONSTRAINT available_event_triggers_check_v11 CHECK (add_to IN (
            'hd',
            'dps',
            'lad',
            'dd',
            'cymad',
            'monoeojd',
            'dmocs',
            'drc',
            'je',
            'opa',
            'exph',
            'dod',
            'tasd',
            'fcd',
            'decr',
            'td',
            'tdreq',
            'dcf',
            'dfaop',
            'ftds',
            'dnmbc',
            'afhd',
            'doorjsbc', 
            'dsococcic',
            'hand_delivery',
            'email',
            'regular_mail_within_state',
            'regular_mail_outside_state',
            'regular_mail_outside_country',
            'dds',
            'dcc',
            'dfcmch',
            'ddsc',
            'dsnejk',
            'dcdr',
            'dlpr',
            'electronic',
            'daafwcoc',
            'daf',
            'ddpodot',
            'fsc'
        ))");


        Schema::table('calculations', function (Blueprint $table) {
            $table->dateTime('fsc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calculations', function (Blueprint $table) {
            $table->dropColumn('fsc')->nullable();
        });

        DB::statement('ALTER TABLE deadlines DROP CONSTRAINT available_event_triggers_check_v11');
        DB::statement("ALTER TABLE deadlines ADD CONSTRAINT available_event_triggers_check_v10 CHECK (add_to IN (
            'hd',
            'dps',
            'lad',
            'dd',
            'cymad',
            'monoeojd',
            'dmocs',
            'drc',
            'je',
            'opa',
            'exph',
            'dod',
            'tasd',
            'fcd',
            'decr',
            'td',
            'tdreq',
            'dcf',
            'dfaop',
            'ftds',
            'dnmbc',
            'afhd',
            'doorjsbc', 
            'dsococcic',
            'hand_delivery',
            'email',
            'regular_mail_within_state',
            'regular_mail_outside_state',
            'regular_mail_outside_country',
            'dds',
            'dcc',
            'dfcmch',
            'ddsc',
            'dsnejk',
            'dcdr',
            'dlpr',
            'electronic',
            'daafwcoc',
            'daf',
            'ddpodot'
        ))");
    }
}
