<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class BulkUploadService
{
    protected $procedure;
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function import($request)
    {
        try {
            $store = $request->storeAs('mysql_uploads', 'personas.csv');
            $localPath = storage_path("app/{$store}");
            $fullPath = '/var/www/html/storage/mysql_uploads/personas.csv';

            $pdo = DB::connection()->getPdo();
            $pdo->beginTransaction();
            $query = "
                LOAD DATA LOCAL INFILE '" . addslashes($fullPath) . "'
                INTO TABLE tmp_personas
                FIELDS TERMINATED BY ',' 
                ENCLOSED BY '\"'
                LINES TERMINATED BY '\\n'
                IGNORE 1 LINES
                (nombre, paterno, materno, telefono, calle, numero_exterior, numero_interior, colonia, cp)
            ";

            $pdo->exec($query);
            $pdo->commit();

            File::delete($localPath);

            $pdo->exec("CALL sp_cargar_personas()");

            $pdo->exec("TRUNCATE TABLE tmp_personas");

            return true;
        } catch (\Throwable $th) {
            Log::error('Exception ocurred while creating the records' . $th);
            return false;
        }
    }
}
