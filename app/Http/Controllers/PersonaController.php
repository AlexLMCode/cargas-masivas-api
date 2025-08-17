<?php

namespace App\Http\Controllers;

use App\Helper\ApiResponse;
use App\Services\BulkUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller
{
    protected $bulkUploadService;

    public function __construct(BulkUploadService $bulkUploadService)
    {
        $this->bulkUploadService = $bulkUploadService;
    }

    public function load(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);

        $res = $this->bulkUploadService->import($request->file('file'));


        if (!$res) {
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::ERROR_IMPORTING, statusCode: self::ERROR);
        }

        return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $res, statusCode: self::SUCCESS);
    }

    public function personas(Request $request)
    {
        $page = (int) $request->get('page', 1);
        $limit = (int) $request->get('limit', 100);;
        $offset = ($page - 1) * $limit;

        $personas = DB::select('CALL sp_get_personas(?, ?)', [$offset, $limit]);

        return response()->json([
            'data' => $personas,
            'page' => $page,
            'per_page' => $limit
        ]);
    }

    public function persona($id)
    {
        $details_telefono = DB::select('CALL sp_get_telefonos(?)', [$id]);
        $details_direccion = DB::select('CALL sp_get_direcciones(?)', [$id]);

        return response()->json([
            'telefonos' => $details_telefono,
            'direcciones' => $details_direccion
        ]);
    }
}
