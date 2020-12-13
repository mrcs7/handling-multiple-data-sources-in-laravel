<?php

namespace App\Console\Commands;

use App\MrCs\DataProviders\CSVProvider;
use App\MrCs\Services\Import\External\SftpService;
use App\MrCs\Services\ProductsImportService;
use App\Jobs\ImportProductsJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;

class ImportDataFromSftp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:sftp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Data From Sftp';

    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    public $sftpService;

    /**
     * ImportDataFromSftp constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->sftpService = app(SftpService::class);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file_path = config('importfromexternal.sftp_server.file_path');
        try {
            $this->sftpService->saveFile($file_path);
        } catch (\Exception $exception) {
            Log::channel('external_import')->info('Error in Fetching CSV File : ' . $exception->getMessage());
            return 1;
        }
        $importedFile = 'app/public/importedCSV.csv';
        $this->productImportService = app(ProductsImportService::class);
        $this->productImportService->setProvider(new CSVProvider());
        ImportProductsJob::dispatch($importedFile, $this->productImportService);
        Log::channel('external_import')->info('Import CSV Job Dispatched');
        return 0;

    }
}
