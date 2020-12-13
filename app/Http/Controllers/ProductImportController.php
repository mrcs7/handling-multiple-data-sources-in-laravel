<?php


namespace App\Http\Controllers;

use App\MrCs\DataProviders\CSVProvider;
use App\MrCs\Services\ProductService;
use App\MrCs\Services\ProductsImportService;
use App\MrCs\Services\UploadService;
use App\Http\Requests\ImportProductsRequest;
use App\Http\Resources\ProductResource;
use App\Jobs\ImportProductsJob;
use Illuminate\Http\Request;

class ProductImportController extends Controller
{
    private $productImportService;

    private $uploadService;

    public function __construct(ProductsImportService  $productImportService,UploadService $uploadService)
    {
        $this->productImportService =$productImportService;
        $this->uploadService = $uploadService;
    }

    public function import(ImportProductsRequest $importProductsRequest)
    {
        $data = $importProductsRequest->all();
        ImportProductsJob::dispatch($data,$this->productImportService);
        return successResponse('Data Are Being Imported');
    }

    public function importCsv(Request $importProductsRequest)
    {
        $data = $importProductsRequest->file('csv_file');
        $file = $this->uploadService->upload($data);
        $this->productImportService->setProvider(new CSVProvider());
        ImportProductsJob::dispatch($file,$this->productImportService);
        return successResponse('Data Are Being Imported');
    }
}
