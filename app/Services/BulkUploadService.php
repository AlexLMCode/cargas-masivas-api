<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class BulkUploadService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function import(Request $request)
    {
        try {
            $path = $request->file('csv_file')->storeAs('public', 'personas.csv');
            $fullPath = storage_path("app/".$path);
            
            $pdo = DB::conection()->getPdo();
            $pdo->beginTransaction();

            $query = "";

        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
