<?php

namespace App\Http\Resources\ResponseBase;

use Illuminate\Http\Resources\Json\JsonResource;

class SuccessEmptyResponse
{
  public static function make(string $message)
  {
    return response()->json(['status' => 'success', 'message' => $message]);
  }
}