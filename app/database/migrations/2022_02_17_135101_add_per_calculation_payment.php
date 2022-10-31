<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPerCalculationPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calculations', function (Blueprint $table) {
            $table->boolean('accessable')->default(true);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->smallInteger('free_calculations')->default(1);
            $table->timestamp('free_calculations_updated_at')->useCurrent();
        });

        Schema::create('stripe_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable()->unique();
            $table->smallInteger('price_amount');
            $table->string('price_id', 30);
            $table->string('product_id', 30);
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
        Schema::table('calculations', function (Blueprint $table) {
            $table->dropColumn('accessable');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('free_calculations');
            $table->dropColumn('free_calculations_updated_at');
        });

        Schema::dropIfExists('stripe_products');
    }
}
