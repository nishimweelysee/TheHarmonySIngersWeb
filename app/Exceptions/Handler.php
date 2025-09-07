<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof PostTooLargeException) {
            return response()->json([
                'error' => 'The uploaded file is too large. Please try a smaller file.'
            ], 413); // HTTP 413 Payload Too Large
        }

        return parent::render($request, $exception);
    }
}