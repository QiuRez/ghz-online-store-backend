<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyProductResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ResponseBase\SuccessResponse;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function getCompanyProducts(Request $request, Company $company)
    {
        $products = $company->products()->get();

        $data = [
            'products' => $products,
            'company' => $company
        ];

        return SuccessResponse::make(CompanyProductResource::make($data), 'Fetch products for company');
    }
}
