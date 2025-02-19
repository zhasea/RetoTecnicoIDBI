<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Services\SaleService;
use Illuminate\Http\JsonResponse;

class SaleController extends Controller
{
    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->saleService->getAllSales());
    }

    public function store(StoreSaleRequest $request): JsonResponse
    {
        $sale = $this->saleService->createSale($request->validated());
        return response()->json(['message' => 'Venta registrada con éxito.', 'sale' => $sale], 201);
    }
}
