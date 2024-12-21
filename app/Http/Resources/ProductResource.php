<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class ProductResource extends JsonResource
{
    private function useCompanyResource($data)
    {
        return CompanyResource::make($data)->resolve();
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->resource->count() && $this->resource instanceof Collection) {
            $this->resource = $this->resource->map(function($item) {
                $item['price'] = number_format((int) $item['price'], 2);
                $item['images'] = config('app.url') . "/storage/{$item['images']}";

                if (isset($item['company'])) {
                    $item['company'] = $this->useCompanyResource($item['company']);
                }
                return $item;
            });
        }

        if ($this->resource instanceof Product) {

            $this->resource['price'] = number_format((int) $this->resource['price'], 2);
            $this->resource['images'] = config('app.url') . "/storage/{$this->resource['images']}";

            if (isset($this->resource['company'])) {
                $this->resource['company'] = $this->useCompanyResource($this->resource['company']);
            }
        }

        return $this->resource->toArray();
    }
}
