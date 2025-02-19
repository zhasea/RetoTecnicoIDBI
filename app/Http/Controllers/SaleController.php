<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['seller', 'customer', 'saleItems.product'])->get();
        return response()->json($sales);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'customer.id_number' => 'required|string|max:20',
            'customer.name' => 'required|string|max:255',
            'customer.email' => 'nullable|email|max:255',
            'customer.document_type_id' => 'required|exists:document_types,id',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            // Capturar el usuario autenticado como vendedor
            $seller_id = auth()->id();

            // Buscar o crear el cliente
            $customer = Customer::firstOrCreate(
                ['id_number' => $request->customer['id_number']],
                [
                    'name' => $request->customer['name'],
                    'email' => $request->customer['email'] ?? null,
                    'document_type_id' => $request->customer['document_type_id'] 

                ]
            );

            // Crear la venta
            $sale = Sale::create([
                'code' => 'VNT-' . now()->timestamp,
                'customer_id' => $customer->id,
                'seller_id' => $seller_id,
                'total_amount' => 0, // Se calculará después
                'sale_date' => now()
            ]);

            $total_amount = 0;

            // Procesar los productos vendidos
            foreach ($request->products as $productData) {
                $product = Product::find($productData['product_id']);
            
                if (!$product) {
                    throw new \Exception("El producto con ID {$productData['product_id']} no existe.");
                }
            
                if (is_null($product->unique_price)) {
                    throw new \Exception("El producto '{$product->name}' no tiene un precio válido.");
                }
            
                // Validar stock suficiente
                if ($product->stock < $productData['quantity']) {
                    throw new \Exception("Stock insuficiente para el producto: {$product->name}");
                }
            
                // Calcular subtotal
                $subtotal = $product->unique_price * $productData['quantity'];
                $total_amount += $subtotal;
            
                // Registrar el detalle de la venta
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $productData['quantity'],
                    'unit_price' => $product->unique_price,
                    'subtotal' => $subtotal
                ]);
            
                // Reducir stock del producto
                $product->decrement('stock', $productData['quantity']);
            }

            // Actualizar el monto total de la venta
            $sale->update(['total_amount' => $total_amount]);

            DB::commit();

            return response()->json([
                'message' => 'Venta registrada con éxito.',
                'sale' => $sale->load(['seller', 'customer', 'saleItems.product'])
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
