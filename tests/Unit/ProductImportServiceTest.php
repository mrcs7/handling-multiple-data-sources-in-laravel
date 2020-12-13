<?php


namespace Tests\Unit;


use App\MrCs\DataProviders\ProviderInterface;
use App\MrCs\Services\ProductsImportService;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProductImportServiceTest extends TestCase
{
    use DatabaseMigrations;

    public $product;

    private $productsImportService;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $mockedProvider = $this->createMock(ProviderInterface::class);
        app()->bind(ProviderInterface::class,get_class($mockedProvider));
        $this->productsImportService = app(ProductsImportService::class);

    }

    /** @test */
    public function import_product_flow_should_not_update_product_attributes_if_it_is_not_changed()
    {
        $this->product = Product::factory()->count(1)->create()->first();
        $updatedDateTime=$this->product->updated_at;
        //Send The Same Product Information to the product flow
        $product = $this->productsImportService->importProductFlow($this->product->toArray());
        $this->assertEquals(false,$product->wasChanged());
    }

    /** @test */
    public function import_product_flow_should_update_product_attributes_if_attribute_changed()
    {
        $this->product = Product::factory()->count(1)->create()->first();
        //Alter Product Values
        $product_info =$this->product->toArray();
        $product_info['name'] = rand(20,100);
        $product = $this->productsImportService->importProductFlow($product_info);
        $this->assertEquals(true,$product->wasChanged());
    }

}
