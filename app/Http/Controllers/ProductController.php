<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use App\Classes\ApiResponseClass;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ProductResource;
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

        return $this->respondWithSuccess(ProductResource::collection($data), 'Product Listed Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $details = [
            'name' => $request->name,
            'details' => $request->details,
            'category_id' => $request->category_id
        ];
        DB::beginTransaction();
        try {
            $product = $this->productRepositoryInterface->store($details); 

            DB::commit();
            return $this->setStatusCode(201)->respondWithSuccess(new ProductResource($product), 'Product Created Successfully');
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

        return $this->respondWithSuccess(new ProductResource($product), 'Product Retrived Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $updateDetails = [
            'name' => $request->name,
            'details' => $request->details,
            'category_id' => $request->category_id
        ];
        DB::beginTransaction();
        try {
            $this->productRepositoryInterface->update($updateDetails, $product->id);

            DB::commit();
            return $this->setStatusCode(201)->respondWithSuccess(new ProductResource($product), 'Product Updated Successfully');
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

        return $this->setStatusCode(204)->respondWithSuccess([], 'Product Deleted Successfully');
    }

    /**
     * Display a listing of the resource.
     */
    public function list(): View
    {
        // $products = Product::latest()->paginate(5);
        $products = Product::with('category')->paginate(5);
          
        return view('products.list', compact('products'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }
}
