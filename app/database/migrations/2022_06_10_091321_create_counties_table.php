<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->bigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states');
            $table->unique(['name', 'state_id']);
            $table->timestamps();
        });

        Schema::table('calculations', function (Blueprint $table) {
            $table->bigInteger('county_id')->nullable();
            $table->foreign('county_id')->references('id')->on('counties');
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
            $table->dropColumn('county_id');
        });
        
        Schema::dropIfExists('counties');
    }
}
