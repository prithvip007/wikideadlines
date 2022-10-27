<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDlprTriggeringEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE deadlines DROP CONSTRAINT available_event_triggers_check_v5');

        DB::statement("ALTER TABLE deadlines ADD CONSTRAINT available_event_triggers_check_v6 CHECK (add_to IN (
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
            'dlpr'
        ))");


        Schema::table('calculations', function (Blueprint $table) {
            $table->dateTime('dlpr')->nullable();
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
            $table->dropColumn('dlpr')->nullable();
        });

        DB::statement('ALTER TABLE deadlines DROP CONSTRAINT available_event_triggers_check_v6');
        DB::statement("ALTER TABLE deadlines ADD CONSTRAINT available_event_triggers_check_v5 CHECK (add_to IN (
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
            'dcdr'
        ))");
    }
}
