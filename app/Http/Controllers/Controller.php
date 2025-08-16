<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //status messages
    public const SUCCESS_MESSAGE = 'Request processed successfully!';
    public const FAILED_MESSAGE = 'Unable to process the request. Please try again!';
    public const EXCEPTION_MESSAGE = 'Exception occurred. Please try again!';

    //status keyword
    public const SUCCESS_STATUS = 'success';
    public const ERROR_STATUS = 'error';
    
    //status code
    public const SUCCESS = 200;
    public const ERROR = 500;
    public const VALIDATION_ERROR = 422;
}
