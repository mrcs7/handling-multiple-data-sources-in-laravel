<?php

namespace App\Console\Commands;

use App\MrCs\Services\Export\External\Abstracts\ExportToExternalApiAbstract;
use App\MrCs\Services\Export\External\ExportToExampleService;
use App\MrCs\Services\ProductService;
use Illuminate\Console\Command;

class ExportProductsToExternalEndpoint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:productsToExternalEndpoint';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command exports products to external endpoint';

    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $exportService;

    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $productService;


    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->productService = app(ProductService::class);
        $this->exportService = app(ExportToExampleService::class);

    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = $this->productService->getAll()->toArray();
        $result = $this->exportService->export(json_encode($data));
        if($result)
        {
            return 0;
        }
        return 1;
    }
}
