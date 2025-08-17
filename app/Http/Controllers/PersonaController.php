<?php

namespace App\Http\Controllers;

use App\Helper\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PersonaController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240', // Max 10MB
        ]);

        try {

            $path = $request->file('csv_file')->storeAs('public', 'products.csv');

            $fullPath = storage_path("app/{$path}");

            $pdo = DB::connection()->getPdo();
            $pdo->beginTransaction();

            $query = "
                LOAD DATA INFILE '" . addslashes($fullPath) . "'
                INTO TABLE employees
                FIELDS TERMINATED BY ',' 
                OPTIONALLY ENCLOSED BY '\"'
                LINES TERMINATED BY '\n'
                IGNORE 1 LINES
                (name, email, @phone, created_at)
                SET phone = TRIM(@phone), created_at=NOW()
            ";

            // Execute the query
            $pdo->exec($query);
            $pdo->commit();

            // Clean up the stored file
            File::delete($fullPath);
            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, statusCode: self::SUCCESS);
        } catch (Exception $exception) {
            Log::error('Exception ocurred while loading the file' . $exception->getMessage());
            return ApiResponse::error(self::ERROR_STATUS, self::EXCEPTION_MESSAGE, self::ERROR);
        }
    }
}
