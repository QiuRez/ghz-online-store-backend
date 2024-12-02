<?php

namespace App\Http\Resources\ResponseBase;

use Illuminate\Http\Resources\Json\JsonResource;

class SuccessResponse
{
  public static function make(JsonResource $jsonResource, string $message)
  {
    return response()->json(['status' => 'success', 'message' => $message, 'data' => $jsonResource]);
  }
}