<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key', 20)->unique();
            $table->string('case_name', 500)->nullable();
            $table->smallInteger('document_type_id');
            $table->smallInteger('delivery_method_id')->nullable();
            $table->smallInteger('state_id');
            $table->dateTime('hd')->nullable();
            $table->dateTime('dps')->nullable();
            $table->dateTime('lad')->nullable();
            $table->dateTime('dd')->nullable();
            $table->dateTime('cymad')->nullable();
            $table->dateTime('monoeojd')->nullable();
            $table->dateTime('dmocs')->nullable();
            $table->dateTime('drc')->nullable();
            $table->dateTime('je')->nullable();
            $table->dateTime('opa')->nullable();
            $table->dateTime('exph')->nullable();
            $table->dateTime('dod')->nullable();
            $table->dateTime('tasd')->nullable();
            $table->dateTime('fcd')->nullable();
            $table->dateTime('decr')->nullable();
            $table->dateTime('td')->nullable();
            $table->dateTime('tdreq')->nullable();
            $table->dateTime('dcf')->nullable();
            $table->dateTime('dfaop')->nullable();
            $table->dateTime('ftds')->nullable();
            $table->dateTime('dnmbc')->nullable();
            $table->dateTime('afhd')->nullable();
            $table->dateTime('doorjsbc')->nullable();
            $table->dateTime('dsococcic')->nullable();
            $table->boolean('same_judge')->nullable();
            $table->string('hearing_courthouse', 50)->nullable();
            $table->string('hearing_courtroom', 50)->nullable();
            $table->tinyInteger('delivery_area')->nullable();
            $table->json('snapshot');
            $table->json('deadlines');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calculations');
    }
}
