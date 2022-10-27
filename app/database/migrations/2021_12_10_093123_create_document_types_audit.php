<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentTypesAudit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_types', function (Blueprint $table) {
            // we create this field to be able to add a user id to audit table
            $table->bigInteger('audit_user_id')->nullable();
        });

        DB::statement('CREATE TABLE document_types_audit AS TABLE document_types WITH NO DATA');

        Schema::table('document_types_audit', function (Blueprint $table) {
            $table->bigIncrements('audit_id');
            $table->enum('audit_action', ['UPDATE', 'DELETE']);
            $table->timestamp('audit_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        DB::statement('
            CREATE OR REPLACE FUNCTION document_types_audit_information() RETURNS TRIGGER 
            AS  
            $document_types_audit$
                BEGIN
                    IF (TG_OP = \'DELETE\' OR TG_OP = \'UPDATE\') THEN
                        INSERT INTO document_types_audit (
                            id,
                            name,
                            small_description,
                            keywords,
                            ask_hearing_courthouse,
                            ask_hearing_courtroom,
                            created_at,
                            deleted_at,
                            updated_at,
                            audit_action,
                            audit_user_id
                        ) VALUES (
                            OLD.id,
                            OLD.name,
                            OLD.small_description,
                            OLD.keywords,
                            OLD.ask_hearing_courthouse,
                            OLD.ask_hearing_courtroom,
                            OLD.created_at,
                            OLD.deleted_at,
                            OLD.updated_at,
                            TG_OP,
                            OLD.audit_user_id
                        );
                    END IF;

                    RETURN null;
                END;
            $document_types_audit$
            language plpgsql;
        ');

        DB::statement('
            CREATE TRIGGER document_types_audit_trigger
            AFTER UPDATE OR DELETE ON document_types
            FOR EACH ROW 
            EXECUTE PROCEDURE document_types_audit_information();          
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_types_audit');
        Schema::table('document_types', function (Blueprint $table) {
            $table->dropColumn('audit_user_id');
        });
        DB::statement('DROP TRIGGER IF EXISTS document_types_audit_trigger ON document_types');
        DB::statement('DROP FUNCTION IF EXISTS document_types_audit_information()');
    }
}
