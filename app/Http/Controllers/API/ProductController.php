<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ProductRequest;
use App\Http\Resources\API\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(Product::query()->simplePaginate(100));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request): ProductResource
    {
        return new ProductResource(Product::query()->create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product): ProductResource
    {
        return new ProductResource(\tap($product)->update($request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): Response
    {
        $product->delete();

        return \response()->noContent();
    }
}
