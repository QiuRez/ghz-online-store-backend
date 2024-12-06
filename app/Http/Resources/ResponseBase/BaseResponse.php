<?php

namespace App\Http\Resources\ResponseBase;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResponse
{
  public function __construct(
    readonly protected string $message
  ) {}
}