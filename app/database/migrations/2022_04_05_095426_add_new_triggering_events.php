<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewTriggeringEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE deadlines DROP CONSTRAINT available_event_triggers_check');

        DB::statement("ALTER TABLE deadlines ADD CONSTRAINT available_event_triggers_check_v2 CHECK (add_to IN (
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
            'regular_mail_outside_country'
        ))");


        Schema::table('calculations', function (Blueprint $table) {
            $table->dateTime('hand_delivery')->nullable();
            $table->dateTime('email')->nullable();
            $table->dateTime('regular_mail_within_state')->nullable();
            $table->dateTime('regular_mail_outside_state')->nullable();
            $table->dateTime('regular_mail_outside_country')->nullable();
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
            $table->dropColumn('hand_delivery')->nullable();
            $table->dropColumn('email')->nullable();
            $table->dropColumn('regular_mail_within_state');
            $table->dropColumn('regular_mail_outside_state');
            $table->dropColumn('regular_mail_outside_country');
        });

        DB::statement('ALTER TABLE deadlines DROP CONSTRAINT available_event_triggers_check_v2');
        DB::statement("ALTER TABLE deadlines ADD CONSTRAINT available_event_triggers_check CHECK (add_to IN ('hd', 'dps', 'lad', 'dd', 'cymad', 'monoeojd', 'dmocs', 'drc', 'je', 'opa', 'exph', 'dod', 'tasd', 'fcd', 'decr', 'td', 'tdreq', 'dcf', 'dfaop', 'ftds', 'dnmbc', 'afhd', 'doorjsbc', 'dsococcic'))");
    }
}
