<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class CartFetchProducts extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (count($this->resource) && $this->resource instanceof Collection) {
            $countsProductsArray = array_count_values(array_column($this->resource->toArray(), 'id'));

            $products = $this->resource->unique();

            $allPrice = array_reduce($this->resource->toArray(), function($sum, $item) {
                return $sum + (int)$item['price'];
            });

            $this->resource['products'] = $products->map(function($item) use($countsProductsArray) {
                $item['count'] = $countsProductsArray[$item['id']];
                $item['price'] = number_format((int) $item['price'] * (int) $item['count'], 2);
                return $item;
            })->toArray();

            $this->resource['allPrice'] = number_format((int)$allPrice, 0);;
        }

        return [
            'products' => $this->resource['products'],
            'allPrice' => $this->resource['allPrice']
        ];
    }
}
