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
        if ($this->resource->count() && $this->resource instanceof Collection) {
            $countsProductsArray = array_count_values(array_column($this->resource->toArray(), 'id'));

            $products = $this->resource->unique();

            $allPrice = 0;

            $allPriceWithDiscount = array_reduce($this->resource->toArray(), function($sum, $item) use(&$allPrice) {
                $allPrice += (float)$item['price'];
                if ($item['price_discount']) {
                    $priceDiscount = (float)str_replace(',', '', $item['price_discount']);
                    return $sum + $priceDiscount;
                }
                return $sum + (float)$item['price'];
            });

            $this->resource['products'] = $products->map(function($item) use($countsProductsArray) {
                $item['count'] = $countsProductsArray[$item['id']];
                $item['price'] = number_format((int) $item['price'] * (int) $item['count'], 2);
                $item['images'] = config('app.url') . "/storage/{$item['images']}";
                return $item;
            })->toArray();

            $this->resource['allPriceDiscount'] = number_format((int)$allPriceWithDiscount, 0);
            $this->resource['allPrice'] = number_format((int)$allPrice, 0);

            return [
                'products' => $this->resource['products'],
                'allPriceDiscount' => $this->resource['allPriceDiscount'],
                'allPrice' => $this->resource['allPrice']
            ];
        }

        return [
            'products' => [],
            'allPriceDiscount' => 0,
            'allPrice' => 0
        ];

    }
}
