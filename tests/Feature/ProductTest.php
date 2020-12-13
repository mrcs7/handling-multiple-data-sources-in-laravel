<?php


namespace Tests\Feature;


use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private $product;

    public function init()
    {
        $this->product = Product::factory()->count(1)->create()->first();
    }

    /** @test */
    public function it_should_return_product_data_successfully()
    {
        $this->init();

        $response = $this->get('/api/v1/products/'.$this->product->identifier,
            [
            'Content-Type' => 'application/json'
        ]);
        $response->assertStatus(200);
        $response->assertJson((new ProductResource($this->product))->toArray(request()));
    }

    /** @test */
    public function it_should_return_not_found_if_product_does_not_exists()
    {
        $this->init();

        $response = $this->get('/api/v1/products/'.rand(15,50),
            [
                'Content-Type' => 'application/json'
            ]);
        $response->assertStatus(404);
    }

}
