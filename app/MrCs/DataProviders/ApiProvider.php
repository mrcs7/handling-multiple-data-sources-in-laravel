<?php


namespace App\MrCs\DataProviders;


use Carbon\Carbon;

class ApiProvider implements ProviderInterface
{
    /**
     * @param $products
     * @return array
     */
    public function parseProducts($products)
    {
        $parsedProducts =[];
        foreach ($products as $product)
        {
            $parsedProduct['name'] = $product['name'];
            $parsedProduct['description'] = $product['description'];
            $parsedProduct['identifier'] = $product['identifier'];
            $parsedProduct['categories'] = $product['categories'];
            $parsedProduct['provider'] = $this->getProviderName();
            $productPrices = [];
            foreach ($product['prices'] as $price)
            {
                $parsedPrice['price'] = $price['price'];
                $parsedPrice['validFrom'] = Carbon::parse($price['validFrom'])->toDateTimeString();
                $parsedPrice['validTo'] = Carbon::parse($price['validTo'])->toDateTimeString();
                $productPrices[]= $parsedPrice;
            }
            $parsedProduct['prices'] = $productPrices;
            $parsedProduct['images'] = $product['images'];
            $parsedProducts[]=$parsedProduct;
            unset($parsedProduct);
        }
        return $parsedProducts;
    }

    /**
     * @return false|string
     */
    public function getProviderName()
    {
        return get_class($this);
    }

}
