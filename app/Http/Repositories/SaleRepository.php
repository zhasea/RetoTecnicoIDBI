<?php

namespace App\Repositories;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SaleRepository
{
    public function getAllSales()
    {
        return Sale::with(['seller', 'customer', 'saleItems.product'])->get();
    }

    public function findOrCreateCustomer(array $customerData)
    {
        return Customer::firstOrCreate(
            ['id_number' => $customerData['id_number']],
            [
                'name' => $customerData['name'],
                'email' => $customerData['email'] ?? null,
                'document_type_id' => $customerData['document_type_id']
            ]
        );
    }

    public function createSale(array $saleData)
    {
        return Sale::create([
            'code' => 'VNT-' . now()->timestamp,
            'customer_id' => $saleData['customer_id'],
            'seller_id' => Auth::id(),
            'total_amount' => 0, // Se actualizará después
            'sale_date' => now()
        ]);
    }

    public function processSaleItems(Sale $sale, array $products)
    {
        $total_amount = 0;

        foreach ($products as $productData) {
            $product = Product::findOrFail($productData['product_id']);

            if (is_null($product->unique_price)) {
                throw new \Exception("El producto '{$product->name}' no tiene un precio válido.");
            }

            if ($product->stock < $productData['quantity']) {
                throw new \Exception("Stock insuficiente para el producto: {$product->name}");
            }

            $subtotal = $product->unique_price * $productData['quantity'];
            $total_amount += $subtotal;

            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $productData['quantity'],
                'unit_price' => $product->unique_price,
                'subtotal' => $subtotal
            ]);

            $product->decrement('stock', $productData['quantity']);
        }

        return $total_amount;
    }
}
