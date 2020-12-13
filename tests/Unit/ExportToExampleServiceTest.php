<?php


namespace Tests\Unit;


use App\MrCs\Services\Export\External\Abstracts\ExportToExternalApiAbstract;
use App\MrCs\Services\Export\External\ExportToExampleService;
use App\Models\Product;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ExportToExampleServiceTest extends TestCase
{
    use DatabaseMigrations;

    public $products;
    public $mocker;
    public $handlerStack;
    public $exportToExampleService;

    public function init()
    {
        $this->products = Product::factory()->count(10)->create();
        $this->mocker       = new MockHandler([]);
        $this->handlerStack = HandlerStack::create($this->mocker);
        $this->exportToExampleService     = $this->app->instance(ExportToExampleService::class, new ExportToExampleService());
    }

    /** @test */
    public function exportProductsToExternalEndpointCommandTest()
    {
        $this->init();
        $this->exampleResponseMock();
        $this->setHandler();
        $this->artisan('export:productsToExternalEndpoint')->assertExitCode(0);
    }

    /** @test */
    public function exportProductsToExternalEndpointCommandTestWhenExceptionHappen()
    {
        $this->init();
        $this->exampleFailedResponseMock();
        $this->setHandler();
        $this->artisan('export:productsToExternalEndpoint')->assertExitCode(1);
    }

    protected function setHandler()
    {
        // pass mocker to handler stack
        $this->handlerStack->setHandler($this->mocker);

        // create client and pass handler
        $this->httpClient = new Client(['handler' => $this->handlerStack]);

        $this->exportToExampleService->setClient($this->httpClient);
    }

    public function exampleResponseMock()
    {
        $this->setMockHandlerResponse(200, ['Data Is being Imported']);
    }

    public function exampleFailedResponseMock()
    {
        $this->setMockHandlerResponse(500, ['Internal Server Error']);
    }

    /**
     * Mock guzzle request to return specific response without send request to third party api
     *
     * @param $responseStatus
     * @param string $responseBody
     */
    protected function setMockHandlerResponse($responseStatus, $responseBody = "")
    {
        // append new response
        $this->mocker->append(new Response($responseStatus, [], json_encode($responseBody)));
    }
}
