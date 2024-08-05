<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductApiController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $products = Product::all();
    
        return $this->respondWithSuccess(ProductResource::collection($products), 'Products retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request): JsonResponse
    {
        $input = $request->all();
   
        $validator = Validator::make($input, $request->rules());
   
        if($validator->fails()){
            return $this->respondWithErrors('Validation Error.', $validator->errors());       
        }
   
        $product = Product::create($input);
   
        return $this->setStatusCode(201)->respondWithSuccess(new ProductResource($product), 'Product created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $product = Product::find($id);
  
        if (is_null($product)) {
            return $this->respondWithErrors('Product not found.');
        }
   
        return $this->respondWithSuccess(new ProductResource($product), 'Product retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product): JsonResponse
    {
        $input = $request->all(); 
   
        $validator = Validator::make($input, $request->rules());
   
        if($validator->fails()){
            return $this->respondWithErrors('Validation Error.', $validator->errors());       
        }
   
        $product->name = $input['name'];
        $product->details = $input['details'];
        $product->category_id = $input['category_id'];
        $product->save();
   
        // $product = Product::findOrFail($product->id);
        // $product->update($input);

        return $this->setStatusCode(201)->respondWithSuccess(new ProductResource($product), 'Product updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
   
        return $this->setStatusCode(204)->respondWithSuccess([], 'Product deleted successfully.');
    }
}
