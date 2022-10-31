<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlertUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE users ADD CONSTRAINT available_authentications_check_v2 CHECK (phone_number is not null or facebook_id is not null or google_id is not null or email is not null)');
        DB::statement('ALTER TABLE users DROP CONSTRAINT available_authentications_check');

        Schema::table('users', function (Blueprint $table) {
            $table->unique('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE users ADD CONSTRAINT available_authentications_check CHECK (phone_number is not null or facebook_id is not null or google_id is not null)');
        DB::statement('ALTER TABLE users DROP CONSTRAINT available_authentications_check_v2');

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('email');
        });
    }
}
