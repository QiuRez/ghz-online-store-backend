<?php

namespace App\Http\Resources\ResponseBase;

class ErrorResponse
{
  public static function make(string $message, int $code = 200)
  {
    return response()->json(['status' => 'error', 'message' => $message])->setStatusCode($code);
  }
}