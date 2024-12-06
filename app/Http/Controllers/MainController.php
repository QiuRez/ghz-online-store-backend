<?php

namespace App\Http\Controllers;

use App\Http\Resources\MainInfoResource;
use App\Http\Resources\ResponseBase\SuccessResponse;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function getMainInfo()
    {
        $categories = Category::all()->map(function($item) {
            $item['image'] = config('app.url') . "/storage/{$item['image']}";
            return $item;
        });

        $companies = Company::all()->map(function($item) {
            $item['logo'] = config('app.url') . "/storage/{$item['logo']}";
            return $item;
        });

        $mainInfo = collect()->merge([
            'categories' => $categories,
            'companies' => $companies
        ]);


        return SuccessResponse::make(new MainInfoResource($mainInfo), 'Fetch main info');
    }
}
