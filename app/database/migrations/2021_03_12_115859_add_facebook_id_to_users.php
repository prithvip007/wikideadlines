<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFacebookIdToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number', 15)->nullable()->change();
            $table->string('facebook_id', 255)->nullable()->unique();

            // OpenID "sub" is within 255 ASCII characters in length
            $table->string('google_id', 255)->nullable()->unique();
        });

        DB::statement('ALTER TABLE users ADD CONSTRAINT available_authentications_check CHECK (phone_number is not null or facebook_id is not null or google_id is not null)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number', 15)->nullable(false)->change();
            $table->dropColumn('facebook_id');
            $table->dropColumn('google_id');
        });

        DB::statement('ALTER TABLE users DROP CONSTRAINT available_authentications_check');
    }
}
