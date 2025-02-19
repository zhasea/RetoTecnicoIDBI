<?php

namespace App\Services;

use App\Repositories\SaleRepository;
use Illuminate\Support\Facades\DB;
use Exception;

class SaleService
{
    protected $saleRepository;

    public function __construct(SaleRepository $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function getAllSales()
    {
        return $this->saleRepository->getAllSales();
    }

    public function createSale(array $data)
    {
        DB::beginTransaction();

        try {
            // Buscar o crear cliente
            $customer = $this->saleRepository->findOrCreateCustomer($data['customer']);

            // Crear la venta
            $sale = $this->saleRepository->createSale([
                'customer_id' => $customer->id
            ]);

            // Procesar productos vendidos
            $total_amount = $this->saleRepository->processSaleItems($sale, $data['products']);

            // Actualizar monto total de la venta
            $sale->update(['total_amount' => $total_amount]);

            DB::commit();

            return $sale->load(['seller', 'customer', 'saleItems.product']);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), 400);
        }
    }
}
