<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ProductService;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        return response()->json($this->productService->getAllProducts(), 200);
    }

    public function show(string $id)
    {
        return response()->json($this->productService->getProductById($id), 200);
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->createProduct($request->validated());

        return response()->json($product, 201);
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $product = $this->productService->updateProduct($id, $request->validated());

        return response()->json($product, 200);
    }

    public function destroy(string $id)
    {
        $this->productService->deleteProduct($id);
        return response()->json(['message' => 'Producto eliminado correctamente'], 200);
    }
}
