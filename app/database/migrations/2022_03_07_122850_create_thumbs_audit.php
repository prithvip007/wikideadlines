<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThumbsAudit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deadlines_audit', function (Blueprint $table) {
            // started_at and ended_at show period when a deadline was actual
            $table->timestamp('started_at');
            $table->timestamp('ended_at');
        });

        Schema::table('deadline_thumbs', function (Blueprint $table) {
            // As we support dealine row versions (slowly changing dimension)
            // we need to know a date that could could indetify time at which a thumb up is actual
            // that time is calculation creation date, so we need to reference it
            $table->unsignedBigInteger('calculation_id');
            $table->foreign('calculation_id')->references('id')->on('calculations');

            // $table->dropIndex(['user_id', 'deadline_id']);
            $table->unique(['user_id', 'deadline_id', 'calculation_id']);
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deadline_thumbs_audit');

        Schema::table('deadline_thumbs', function (Blueprint $table) {
            $table->dropColumn('calculation_id');
        });
    }
}
