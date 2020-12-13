<?php


namespace App\MrCs\Services;


use App\Models\Product;

class ProductService
{
    /**
     * @param $identifier
     * @return mixed
     */
    public function getByIdentifier($identifier)
    {
        return Product::where('identifier',$identifier)->first();
    }

    /**
     * @param $productInfo
     * @return mixed
     */
    public function create($productInfo)
    {
        $product = Product::firstOrNew(['identifier'=>$productInfo['identifier']]);
        $product->fill($productInfo)->save();
        return $product;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return Product::select('name','identifier','description','categories','prices','images')->get();
    }

}
