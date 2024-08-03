<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Interfaces\ProductRepositoryInterface;

class ProductController extends ApiController
{

    public function __construct(private ProductRepositoryInterface $productRepositoryInterface)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->productRepositoryInterface->index();

        return $this->response(ProductResource::collection($data));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $details = [
            'name' => $request->name,
            'details' => $request->details
        ];
        DB::beginTransaction();
        try {
            $product = $this->productRepositoryInterface->store($details);

            DB::commit();
            return ApiResponseClass::sendResponse(new ProductResource($product), 'Product Create Successful', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product = $this->productRepositoryInterface->show($product->id);

        return ApiResponseClass::sendResponse(new ProductResource($product), '', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $updateDetails = [
            'name' => $request->name,
            'details' => $request->details
        ];
        DB::beginTransaction();
        try {
            $product = $this->productRepositoryInterface->update($updateDetails, $product->id);

            DB::commit();
            return ApiResponseClass::sendResponse($product, 'Product Update Successful', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->productRepositoryInterface->delete($product->id);

        return ApiResponseClass::sendResponse([], 'Product Delete Successful', 204);
    }
}
