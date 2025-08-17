<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_get_direcciones');
        DB::unprepared('
            CREATE PROCEDURE sp_get_direcciones(IN persona_id INT)
            BEGIN
                SELECT calle, numero_exterior, numero_interior, colonia, cp
                FROM direccion d WHERE d.persona_id = persona_id;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_get_direcciones');
    }
};
