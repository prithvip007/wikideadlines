<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeadlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deadlines', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->text('name');
            $table->smallInteger('document_type_id');
            $table->smallInteger('days');
            $table->enum('days_type', ['court', 'calendar', 'next_business_day']); // TODO: Create our own type base on ENUM
            $table->string('add_to', 50); // TODO: Create our own type base on ENUM
            $table->boolean('subtract_delivery_days')->default(false);
            $table->boolean('check_dps_preciseness')->default(false);
            $table->boolean('calculate_if_same_judge')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('CREATE UNIQUE INDEX deadlines_check_dps_preciseness_true_unique on deadlines (check_dps_preciseness, document_type_id) where check_dps_preciseness = true;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deadlines');
    }
}
