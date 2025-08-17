<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BulkUploadService
{
    protected $procedure;
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function import($request)
    {
            $path = $request->storeAs('mysql_uploads', 'personas.csv');
            $fullPath = '/var/lib/mysql_uploads/personas.csv';
            dd($path);
        // try {
        //     $path = $request->storeAs('public', 'personas.csv');
        //     $fullPath = storage_path("app/" . $path);
        //     DB::select("CALL sp_cargar_personas(" . $fullPath . ")");
        //     return true;
        // } catch (\Throwable $th) {
        //     Log::error('Exception ocurred while creating the records' . $th);
        //     return false;
        // }

        DB::connection()->getPdo()->exec("
    LOAD DATA LOCAL INFILE '" . addslashes($fullPath) . "'
    INTO TABLE tmp_personas
    FIELDS TERMINATED BY ',' 
    ENCLOSED BY '\"'
    LINES TERMINATED BY '\\n'
    IGNORE 1 LINES
    (nombre, paterno, materno, telefono, calle, numero_exterior, numero_interior, colonia, cp)
");

DB::statement("CALL sp_procesar_personas();");
    }
}
