<?php

namespace App\Http\Services;

use App\Http\Repositories\ProductRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Exceptions\ProductException;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts()
    {
        return $this->productRepository->getAllProducts();
    }

    public function getProductById(string $id)
    {
        return $this->productRepository->findProductById($id);
    }

    public function createProduct(array $data)
    {
        return $this->productRepository->createProduct($data);
    }

    public function updateProduct(string $id, array $data)
    {
        return $this->productRepository->updateProduct($id, $data);
    }

    public function deleteProduct(string $id)
    {
        return $this->productRepository->deleteProduct($id);
    }
}
