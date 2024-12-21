<?php

namespace App\Service;

use App\Enums\DiscountTypeEnum;
use App\Models\Product;

class PriceGenerator
{
  public static function calculatePrice(Product $product): string | bool
  {
    if ($product->discount->count()) {
      $discount = $product->discount->first();

      $price = (float) number_format((float)$product->getOriginal('price'), 2, '.', '');


      if ($discount->type == DiscountTypeEnum::PERCENT->value) {
        $price -= $price * ((int)$discount->amount / 100);
        return (string)$price;
      }

      if ($discount->type == DiscountTypeEnum::CURRENCY->value) {
        $price -= (int)$discount->amount;
        return (string)$price;
      }
    }

    return false;
  }
}