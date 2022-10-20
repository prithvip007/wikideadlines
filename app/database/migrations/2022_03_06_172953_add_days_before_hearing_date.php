<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDaysBeforeHearingDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_types', function (Blueprint $table) {
            // this field should be present only for motions 
            // and it is used in earliest hearing date calculations
            // https://app.asana.com/0/0/1200655530164987/1200856746673137/f
            $table->smallInteger('days_before_hd_court')->nullable();
            $table->smallInteger('days_before_hd_calendar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_types', function (Blueprint $table) {
            $table->dropColumn('days_before_hd_court');
            $table->dropColumn('days_before_hd_calendar');
        });
    }
}
