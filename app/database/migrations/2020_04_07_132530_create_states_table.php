<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 300);
            $table->string('timezone', 50);
            $table->boolean('preselected')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

       DB::statement('CREATE UNIQUE INDEX states_preselected_true_unique on states (preselected) where preselected = true;');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }
}
