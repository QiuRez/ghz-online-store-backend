<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        if ($this->resource instanceof Category) {
            $this->resource['image'] = config('app.url') . "/storage/{$this->resource['image']}";
        }

        return $this->resource->toArray();
    }
}
