<?php

namespace App\Http\Controllers;

use App\Http\Resources\MainInfoResource;
use App\Http\Resources\ResponseBase\SuccessResponse;
use App\Http\Resources\SearchResource;
use App\Models\Category;
use App\Models\Company;
use App\Models\Product;

class MainController extends Controller
{
    public function getMainInfo()
    {
        $mainInfo = collect()->merge([
            'categories' => Category::where('status', '=', true)->get(),
            'companies' => Company::all()
        ]);

        return SuccessResponse::make(new MainInfoResource($mainInfo), 'Fetch main info');
    }

    public function search($q)
    {
        $products = Product::whereLike('title', "%$q%")->limit(5)->get();

        return SuccessResponse::make(new SearchResource($products), 'Fetch main info');
    }
}
