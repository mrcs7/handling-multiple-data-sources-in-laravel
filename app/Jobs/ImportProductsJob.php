<?php

namespace App\Jobs;

use App\MrCs\Services\ProductsImportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $productsImportService;

    private $data;

    /**
     * Create a new job instance.
     *
     * @param ProductsImportService $productsImportService
     * @param $data
     */
    public function __construct($data,ProductsImportService $productsImportService)
    {
       $this->productsImportService = $productsImportService;
       $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->productsImportService->importProducts($this->data);
    }
}
