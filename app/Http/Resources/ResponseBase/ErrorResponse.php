<?php

namespace App\Http\Resources\ResponseBase;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResponse
{
  public static function make(string $message)
  {
    return response()->json(['status' => 'error', 'message' => $message]);
  }
}