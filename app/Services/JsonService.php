<?php

namespace App\Services;

class JsonService
{
    public function jsonResponse($status, $message, $data){
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];
    }
}