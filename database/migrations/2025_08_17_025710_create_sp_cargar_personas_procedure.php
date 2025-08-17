<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_cargar_personas');
        DB::unprepared('
            CREATE PROCEDURE sp_cargar_personas(IN ruta_csv VARCHAR(500))
            BEGIN
                TRUNCATE TABLE tmp_personas;

                SET @sql = CONCAT(
                    "LOAD DATA LOCAL INFILE \'",
                    ruta_csv,
                    "\' INTO TABLE tmp_personas FIELDS TERMINATED BY \',\' ENCLOSED BY \'\"\' LINES TERMINATED BY \'\\n\' IGNORE 1 LINES (nombre, paterno, materno, telefono, calle, numero_exterior, numero_interior, colonia, cp)"
                );

                PREPARE stmt FROM @sql;
                EXECUTE stmt;
                DEALLOCATE PREPARE stmt;

                INSERT INTO persona (nombre, paterno, materno)
                SELECT DISTINCT t.nombre, t.paterno, t.materno
                FROM tmp_personas t
                LEFT JOIN persona p
                ON p.nombre = t.nombre AND p.paterno = t.paterno AND p.materno = t.materno
                WHERE p.id IS NULL;

                INSERT INTO telefono (persona_id, telefono)
                SELECT DISTINCT p.id, t.telefono
                FROM tmp_personas t
                INNER JOIN persona p
                ON p.nombre = t.nombre AND p.paterno = t.paterno AND p.materno = t.materno
                LEFT JOIN telefono tel
                ON tel.persona_id = p.id AND tel.telefono = t.telefono
                WHERE tel.id IS NULL;

                INSERT INTO direccion (persona_id, calle, numero_exterior, numero_interior, colonia, cp)
                SELECT DISTINCT p.id, t.calle, t.numero_exterior, t.numero_interior, t.colonia, t.cp
                FROM tmp_personas t
                INNER JOIN persona p
                ON p.nombre = t.nombre AND p.paterno = t.paterno AND p.materno = t.materno
                LEFT JOIN direccion d
                ON d.persona_id = p.id 
                AND d.calle = t.calle 
                AND d.numero_exterior = t.numero_exterior
                AND d.numero_interior = t.numero_interior
                AND d.colonia = t.colonia
                AND d.cp = t.cp
                WHERE d.id IS NULL;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_cargar_personas');
    }
};
