<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisibilityTypesToDeadlines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deadlines', function (Blueprint $table) {
            $table->json('visibility_scopes', [
                'no_display:document_received',
                'no_check:document_received',
                'no_display:document_to_send',
                'no_check:document_to_send'
            ])->default('[]');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deadlines', function (Blueprint $table) {
            $table->dropColumn('visibility_scopes');
        });
    }
}
