<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_types', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 300);
            $table->text('small_description')->nullable();
            $table->text('keywords')->nullable();
            $table->boolean('ask_hearing_courthouse')->default(false);
            $table->boolean('ask_hearing_courtroom')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('document_type_delivery_method', function (Blueprint $table) {
            $table->smallInteger('delivery_method_id');
            $table->smallInteger('document_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_types');
        Schema::dropIfExists('document_type_delivery_method');
    }
}
