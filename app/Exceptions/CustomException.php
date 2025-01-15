<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    public $errorCode;
    public $statusCode;

    public function __construct($message, $errorCode, $statusCode){
        parent::__construct($message);
        $this->errorCode = $errorCode;
        $this->statusCode = $statusCode;
    }


    public function render($request){
        return response()->json([
            'error_code' => $this->errorCode,
            'error_message' => $this->getMessage(),
        ], $this->statusCode);
    }
}
