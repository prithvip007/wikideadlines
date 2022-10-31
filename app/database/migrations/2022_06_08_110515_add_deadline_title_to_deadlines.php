<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeadlineTitleToDeadlines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deadlines', function (Blueprint $table) {
            $table->string('title')->nullable();
        });

        Schema::table('deadlines_audit', function (Blueprint $table) {
            $table->string('title')->nullable();
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
                            audit_user_id,
                            started_at,
                            ended_at,
                            title
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
                            OLD.audit_user_id,
                            OLD.updated_at,
                            NEW.updated_at,
                            OLD.title
                        );
                    END IF;

                    RETURN null;
                END;
            $deadlines_audit$
            language plpgsql;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deadlines', function (Blueprint $table) {
            $table->dropColumn('title');
        });

        Schema::table('deadlines_audit', function (Blueprint $table) {
            $table->dropColumn('title')();
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
                            audit_user_id,
                            started_at,
                            ended_at
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
                            OLD.audit_user_id,
                            OLD.updated_at,
                            NEW.updated_at
                        );
                    END IF;

                    RETURN null;
                END;
            $deadlines_audit$
            language plpgsql;
        ');
    }
}
