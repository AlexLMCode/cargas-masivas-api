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
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_get_personas');
        DB::unprepared('
            CREATE PROCEDURE sp_get_personas(IN offset INT, IN limit_count INT)
            BEGIN
                SELECT p.id, p.nombre, p.paterno, p.materno
                FROM persona p
                ORDER BY p.id
                LIMIT offset, limit_count;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_get_personas');
    }
};
