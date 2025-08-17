<?php

namespace App\Http\Controllers;

use App\Helper\ApiResponse;
use App\Services\BulkUploadService;
use Illuminate\Http\Request;

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
}
