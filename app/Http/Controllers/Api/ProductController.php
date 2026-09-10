<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkInsertProductsRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductsBulkRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    public function setData(StoreProductRequest $request): JsonResponse
    {
        $product = Product::create($request->validated());

        return response()->json(['data' => $product], 201);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function getData(string $id): JsonResponse
    {
        if (! ctype_digit($id)) {
            return response()->json(['message' => 'Invalid product id.'], 422);
        }

        $product = Product::with('seller')->find($id);

        if (! $product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        if ($product->display_size <= 5) {
            return response()->json(['data' => null]);
        }

        return response()->json([
            'data' => [
                'phone_name' => $product->phone_name,
                'seller_name' => $product->seller->seller_name,
            ],
        ]);
    }

    /**
     * @param UpdateProductsBulkRequest $request
     * @return JsonResponse
     */
    public function updateDataBulk(UpdateProductsBulkRequest $request): JsonResponse
    {
        $updated = Product::whereIn('id', $request->validated('ids'))->update(['cost' => $request->validated('cost')]);

        return response()->json(['updated' => $updated]);
    }

    /**
     * @param BulkInsertProductsRequest $request
     * @return JsonResponse
     */
    public function bulkInsert(BulkInsertProductsRequest $request): JsonResponse
    {
        $now = now();

        $rows = array_map(
            static fn (array $product): array => [...$product, 'created_at' => $now, 'updated_at' => $now],
            $request->validated(),
        );

        Product::insert($rows);

        return response()->json(['inserted' => count($rows)], 201);
    }
}
