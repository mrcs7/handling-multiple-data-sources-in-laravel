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
use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;

class ProductController extends Controller
{

    /**
     * @var ProductService
     */
    private $productService;

    /**
     * ProductController constructor.
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @param $identifier
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($identifier)
    {
        $result = $this->productService->getByIdentifier($identifier);
        if(!$result){
            return notFoundResponse('Product Not Found');
        }
        return successResponseWithData(new ProductResource($this->productService->getByIdentifier($identifier)));
    }
}
