<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlertDeadlines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE deadlines ADD CONSTRAINT available_event_triggers_check CHECK (add_to IN ('hd', 'dps', 'lad', 'dd', 'cymad', 'monoeojd', 'dmocs', 'drc', 'je', 'opa', 'exph', 'dod', 'tasd', 'fcd', 'decr', 'td', 'tdreq', 'dcf', 'dfaop', 'ftds', 'dnmbc', 'afhd', 'doorjsbc', 'dsococcic'))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE deadlines DROP CONSTRAINT available_event_triggers_check');
    }
}
