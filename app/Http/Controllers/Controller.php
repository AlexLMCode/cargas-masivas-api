<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //status messages
    public const SUCCESS_MESSAGE = 'Request processed successfully!';
    public const FAILED_MESSAGE = 'Unable to process the request. Please try again!';
    public const EXCEPTION_MESSAGE = 'Exception occurred. Please try again!';
    public const INVALID_CREDENTIALS = 'Unable to process the login request due to invalid credentials';
    public const USER_NOT_FOUND = 'User request not found';
    public const USER_LOGED_OUT = 'User loged out successfully';
    public const ERROR_IMPORTING = 'Error while importing the file';

    //status keyword
    public const SUCCESS_STATUS = 'success';
    public const ERROR_STATUS = 'error';
    
    //status code
    public const SUCCESS = 200;
    public const ERROR = 500;
    public const VALIDATION_ERROR = 422;
}
