<?php

// app/Exceptions/ApiException.php
namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'error' => [
                'message' => $this->getMessage(),
                'code' => $this->getCode(),
            ],
        ], $this->getCode());
    }
}

