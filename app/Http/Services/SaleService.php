<?php

namespace App\Http\Services;

use App\Http\Repositories\SaleRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesReportExport;
use Illuminate\Support\Facades\Storage;

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
            $customer = $this->saleRepository->findOrCreateCustomer($data['customer']);

            $sale = $this->saleRepository->createSale([
                'customer_id' => $customer->id
            ]);

            $total_amount = $this->saleRepository->processSaleItems($sale, $data['products']);

            $sale->update(['total_amount' => $total_amount]);

            DB::commit();

            return $sale->load(['seller', 'customer', 'saleItems.product']);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), 400);
        }
    }

    public function getSalesReport($from = null, $to = null)
    {
        return $this->saleRepository->getSalesReport($from, $to);
    }

    public function exportSalesToXlsx($from = null, $to = null)
    {
        $fileName = 'sales_report_' . now()->format('Ymd_His') . '.xlsx';
        $filePath = 'public/reports/' . $fileName;

        Excel::store(new SalesReportExport($this->getSalesReport($from, $to)), $filePath);

        $downloadUrl = Storage::url('reports/' . $fileName);

        return $downloadUrl;
    }
}
