<?php

namespace App\Http\Repositories;

use App\Models\Product;
use App\Exceptions\ProductException;

class ProductRepository
{
    public function getAllProducts()
    {
        return Product::all();
    }

    public function findProductById(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            throw new ProductException("Producto no encontrado", 404);
        }
        return $product;
    }

    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    public function updateProduct(string $id, array $data)
    {
        $product = $this->findProductById($id);
        $product->update($data);
        return $product;
    }

    public function deleteProduct(string $id)
    {
        $product = $this->findProductById($id);
        $product->delete();
        return true;
    }
}
