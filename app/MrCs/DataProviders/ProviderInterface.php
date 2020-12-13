<?php


namespace App\MrCs\DataProviders;


interface ProviderInterface
{
    public function parseProducts($products);

    public function getProviderName();

}
