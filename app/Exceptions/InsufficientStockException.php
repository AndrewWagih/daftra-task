<?php

namespace App\Exceptions;

use Exception;

class InsufficientStockException extends Exception
{
    public function __construct(string $message = "Insufficient stock to transfer.", int $code = 400)
    {
        parent::__construct($message, $code);
    }

    public function render($request)
    {
        return response()->json([
            'error' => in_array($this->code ,[200,201])?true:false,
            'message' => $this->getMessage()
        ], $this->getCode());
    }
}
