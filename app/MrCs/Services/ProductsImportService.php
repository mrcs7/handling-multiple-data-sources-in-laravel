<?php


namespace App\MrCs\Services;


use App\MrCs\DataProviders\ProviderInterface;

class ProductsImportService
{
    /**
     * @var ProductService
     */
    private $productService;

    /**
     * @var ProviderInterface
     */
    private $provider;

    /**
     * ProductsImportService constructor.
     * @param ProviderInterface $provider
     * @param ProductService $productService
     */
    public function __construct(ProviderInterface $provider,ProductService $productService)
    {
        $this->productService = $productService;
        $this->provider = $provider;
    }

    /**
     * @param $data
     * @return mixed
     */
    private function parseData($data)
    {
        return $this->provider->parseProducts($data);
    }

    /**
     * @param $data
     * @return array
     */
    public function importProducts($data)
    {
        $products = $this->parseData($data);
        $imported = [];
        foreach ($products as $product)
        {
            $imported[] =$this->importProductFlow($product);
        }
        return $imported;
    }

    /**
     * @param $productInfo
     * @return mixed
     */
    public function importProductFlow($productInfo)
    {
        return $this->productService->create($productInfo);
    }

    /**
     * @param ProviderInterface $provider
     */
    public function setProvider(ProviderInterface  $provider)
    {
        $this->provider = $provider;
    }

}
