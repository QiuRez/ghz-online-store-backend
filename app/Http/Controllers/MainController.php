<?php

namespace App\Http\Controllers;

use App\Http\Resources\MainInfoResource;
use App\Http\Resources\ResponseBase\SuccessResponse;
use App\Models\Category;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function getMainInfo()
    {
        $categories = Category::all()->map(function($item) {
            $item['image'] = config('app.url') . "/storage/{$item['image']}";
            return $item;
        });

        $mainInfo = collect()->merge([
            'categories' => $categories
        ]);


        return SuccessResponse::make(new MainInfoResource($mainInfo), 'Fetch main info');
    }
}
