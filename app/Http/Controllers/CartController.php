<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartProductRequest;
use App\Http\Resources\CartFetchProducts;
use App\Http\Resources\ResponseBase\ErrorResponse;
use App\Http\Resources\ResponseBase\SuccessEmptyResponse;
use App\Http\Resources\ResponseBase\SuccessResponse;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function getCart(Request $request)
    {
        $products = $request->user()->products()->orderBy('id')->get();

        return SuccessResponse::make(CartFetchProducts::make($products), 'Get products from user cart');
    }

    public function addProduct(CartProductRequest $request)
    {
        if ($product = Product::find($request->get('product_id'))) {
            $request->user()->products()->attach($product->id);
            return SuccessResponse::make(CartFetchProducts::make($request->user()->products()->orderBy('id')->get()), 'Product success add to user cart');
        }
        return ErrorResponse::make('Product not found');
    }
    public function removeProduct(CartProductRequest $request)
    {
        if ($product = $request->user()->products()->find($request->get('product_id'))) {
            DB::table('product_user')
                ->where([
                    ['product_id', '=', $product->id],
                    ['user_id', '=', $request->user()->id]])
                ->take(1)
                ->delete();

            return SuccessResponse::make(CartFetchProducts::make($request->user()->products()->orderBy('id')->get()), 'Product success remove from user cart');
        }
        return ErrorResponse::make('Product not found');
    }

    public function removeAllProduct(CartProductRequest $request)
    {
        $request->user()->products()->detach($request->get('product_id'));

        return SuccessResponse::make(CartFetchProducts::make($request->user()->products()->get()), 'Product success remove from user cart');
    }
}
