<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Http\Services\SaleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


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

    public function generateReport(Request $request): JsonResponse
    {
        $from = $request->query('from');
        $to = $request->query('to');

        $salesData = $this->saleService->getSalesReport($from, $to);

        $excelUrl = $this->saleService->exportSalesToXlsx($from, $to);

        return response()->json([
            'message' => 'Reporte generado exitosamente.',
            'sales_data' => $salesData,
            'excel_url' => $excelUrl
        ]);
    }
}
