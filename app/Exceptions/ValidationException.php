<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ValidationException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'errors' => json_decode($this->getMessage(), true)
        ], 422);
    }
}
