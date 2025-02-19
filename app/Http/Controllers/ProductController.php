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
     /**
     * Listar Productos
     */
    public function index()
    {
        return response()->json($this->productService->getAllProducts(), 200);
    }

     /**
     * Listar un Producto
     */
    public function show(string $id)
    {
        return response()->json($this->productService->getProductById($id), 200);
    }

     /**
     * Registro de un producto
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->createProduct($request->validated());

        return response()->json($product, 201);
    }

     /**
     * Actualizacion de un producto
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = $this->productService->updateProduct($id, $request->validated());

        return response()->json($product, 200);
    }

     /**
     * Eliminacion de un producto
     */
    public function destroy(string $id)
    {
        $this->productService->deleteProduct($id);
        return response()->json(['message' => 'Producto eliminado correctamente'], 200);
    }
}
