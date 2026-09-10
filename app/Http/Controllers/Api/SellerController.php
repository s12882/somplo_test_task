<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSellerRequest;
use App\Models\Seller;
use Illuminate\Http\JsonResponse;

class SellerController extends Controller
{
    /**
     * @param StoreSellerRequest $request
     * @return JsonResponse
     */
    public function setData(StoreSellerRequest $request): JsonResponse
    {
        $seller = Seller::create($request->validated());

        return response()->json(['data' => $seller], 201);
    }
}
