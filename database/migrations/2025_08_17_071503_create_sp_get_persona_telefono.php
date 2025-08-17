<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_get_telefonos');
        DB::unprepared('
            CREATE PROCEDURE sp_get_telefonos(IN persona_id INT)
            BEGIN
                SELECT * FROM telefono t WHERE t.persona_id = persona_id;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_get_telefonos');
    }
};
