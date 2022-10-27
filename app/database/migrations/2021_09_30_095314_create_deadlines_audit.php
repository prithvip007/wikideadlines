<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeadlinesAudit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deadlines', function (Blueprint $table) {
            // we create this field to be able to add a user id to audit table
            $table->bigInteger('audit_user_id')->nullable();
        });

        DB::statement('CREATE TABLE deadlines_audit AS TABLE deadlines WITH NO DATA');

        Schema::table('deadlines_audit', function (Blueprint $table) {
            $table->bigIncrements('audit_id');
            $table->enum('audit_action', ['UPDATE', 'DELETE']);
            $table->timestamp('audit_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        DB::statement('
            CREATE OR REPLACE FUNCTION deadlines_audit_information() RETURNS TRIGGER 
            AS  
            $deadlines_audit$
                BEGIN
                    IF (TG_OP = \'DELETE\' OR TG_OP = \'UPDATE\') THEN
                        INSERT INTO deadlines_audit (
                            id,
                            name,
                            document_type_id,
                            days,
                            days_type,
                            add_to,
                            subtract_delivery_days,
                            check_dps_preciseness,
                            calculate_if_same_judge,
                            created_at,
                            deleted_at,
                            updated_at,
                            best_practices,
                            audit_action,
                            audit_user_id
                        ) VALUES (
                            OLD.id,
                            OLD.name,
                            OLD.document_type_id,
                            OLD.days,
                            OLD.days_type,
                            OLD.add_to,
                            OLD.subtract_delivery_days,
                            OLD.check_dps_preciseness,
                            OLD.calculate_if_same_judge,
                            OLD.created_at,
                            OLD.deleted_at,
                            OLD.updated_at,
                            OLD.best_practices,
                            TG_OP,
                            OLD.audit_user_id
                        );
                    END IF;

                    RETURN null;
                END;
            $deadlines_audit$
            language plpgsql;
        ');

        DB::statement('
            CREATE TRIGGER deadlines_audit_trigger
            AFTER UPDATE OR DELETE ON deadlines
            FOR EACH ROW 
            EXECUTE PROCEDURE deadlines_audit_information();          
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deadlines_audit');
        Schema::table('deadlines', function (Blueprint $table) {
            $table->dropColumn('audit_user_id');
        });
        DB::statement('DROP TRIGGER IF EXISTS deadlines_audit_trigger ON deadlines_audit');
        DB::statement('DROP FUNCTION IF EXISTS deadlines_audit_information()');
    }
}
