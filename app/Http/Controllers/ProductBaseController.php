<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ProductBaseStoreRequest;
use App\Http\Requests\ProductBaseUpdateRequest;

class ProductBaseController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::with('category')->latest()->paginate(5);

        return view('products.index', compact('products'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductBaseStoreRequest $request): RedirectResponse
    {
        $input = $request->all(); 

        $input['category_id'] =  1;
        $input['status'] =  1;

        Product::create($input);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        $product = Product::findOrFail($product->id);

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        return view('products.edit', compact('product')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductBaseUpdateRequest $request, Product $product): RedirectResponse
    {
        $input = $request->validated(); 

        $input['category_id'] =  1;
        $input['status'] =  1;

        $product->update($input);

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}