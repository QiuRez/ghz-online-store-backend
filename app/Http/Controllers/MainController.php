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
        $mainInfo = collect()->merge([
            'categories' => Category::all(),
            'companies' => Company::all()
        ]);

        return SuccessResponse::make(new MainInfoResource($mainInfo), 'Fetch main info');
    }
}
