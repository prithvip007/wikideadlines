<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE SEQUENCE delivery_methods_order_seq');

        Schema::create('delivery_methods', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 300);
            $table->text('description')->nullable();
            $table->text('warning')->nullable();
            $table->smallInteger('days');
            $table->enum('days_type', ['court', 'calendar', 'next_business_day']);
            $table->smallInteger('outside_state_days')->nullable();
            $table->smallInteger('outside_country_days')->nullable();
            $table->boolean('preselected')->default(false);
            $table->smallInteger('order')->default(DB::raw('nextval(\'delivery_methods_order_seq\')'));
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('ALTER SEQUENCE delivery_methods_order_seq OWNED BY delivery_methods.order');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_methods');
    }
}
