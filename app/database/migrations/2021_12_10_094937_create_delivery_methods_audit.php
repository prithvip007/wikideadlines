<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryMethodsAudit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_methods', function (Blueprint $table) {
            // we create this field to be able to add a user id to audit table
            $table->bigInteger('audit_user_id')->nullable();
        });

        DB::statement('CREATE TABLE delivery_methods_audit AS TABLE delivery_methods WITH NO DATA');

        Schema::table('delivery_methods_audit', function (Blueprint $table) {
            $table->bigIncrements('audit_id');
            $table->enum('audit_action', ['UPDATE', 'DELETE']);
            $table->timestamp('audit_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        DB::statement('
            CREATE OR REPLACE FUNCTION delivery_methods_audit_information() RETURNS TRIGGER 
            AS  
            $delivery_methods_audit$
                BEGIN
                    IF (TG_OP = \'DELETE\' OR TG_OP = \'UPDATE\') THEN
                        INSERT INTO delivery_methods_audit (
                            id,
                            name,
                            description,
                            warning,
                            days,
                            days_type,
                            outside_state_days,
                            outside_country_days,
                            preselected,
                            created_at,
                            deleted_at,
                            updated_at,
                            audit_action,
                            audit_user_id
                        ) VALUES (
                            OLD.id,
                            OLD.name,
                            OLD.description,
                            OLD.warning,
                            OLD.days,
                            OLD.days_type,
                            OLD.outside_state_days,
                            OLD.outside_country_days,
                            OLD.preselected,
                            OLD.created_at,
                            OLD.deleted_at,
                            OLD.updated_at,
                            TG_OP,
                            OLD.audit_user_id
                        );
                    END IF;

                    RETURN null;
                END;
            $delivery_methods_audit$
            language plpgsql;
        ');

        DB::statement('
            CREATE TRIGGER delivery_methods_audit_trigger
            AFTER UPDATE OR DELETE ON delivery_methods
            FOR EACH ROW 
            EXECUTE PROCEDURE delivery_methods_audit_information();          
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_methods_audit');
        Schema::table('delivery_methods', function (Blueprint $table) {
            $table->dropColumn('audit_user_id');
        });
        DB::statement('DROP TRIGGER IF EXISTS delivery_methods_audit_trigger ON delivery_methods');
        DB::statement('DROP FUNCTION IF EXISTS delivery_methods_audit_information()');
    }
}
