<?php


namespace App\MrCs\DataProviders;


class CSVProvider implements ProviderInterface
{
    /**
     * @param $file
     * @return array
     */
    public function parseProducts($file)
    {
        $data= $this->csvToArray($file,';');
        $parsedProducts =[];
        foreach ($data as $product)
        {
            $parsedProduct['name'] = $product['name'];
            $parsedProduct['description'] = $product['description'];
            $parsedProduct['identifier'] = $product['identifier'];
            $parsedProduct['categories'] = explode(',',$product['categories']);
            $parsedProduct['provider'] = $this->getProviderName();
            $productPrices = [];
            $prices = explode(',',$product['prices']);
            array_walk($prices,function ($value) use(&$productPrices){
               $price = explode('|',$value);
               $parsedPrice['price'] = $price[0];
               $parsedPrice['validFrom'] = $price[1];
               $parsedPrice['validTo'] = $price[2];
               $productPrices[] =$parsedPrice;
            });
            $parsedProduct['prices'] = $productPrices;
            $parsedProduct['images']=explode(',',$product['images']);
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

    /**
     * @param string $filename
     * @param string $delimiter
     * @return array|false
     */
    private function csvToArray($filename = '', $delimiter = ';')
    {
        $filename= storage_path($filename);
        if (!file_exists($filename) || !is_readable($filename)){
            return false;
        }
        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }
}
