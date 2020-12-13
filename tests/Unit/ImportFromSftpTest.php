<?php


namespace Tests\Unit;


use App\MrCs\Services\Import\External\SftpService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Util\Exception;
use Tests\TestCase;

class ImportFromSftpTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function importFromSftpSuccessTest()
    {
        $adapter = $this->createMock(SftpService::class);
        $adapter->method('saveFile')
            ->willReturn(Storage::get('Test.csv'));
        $this->app->instance(SftpService::class,$adapter);
        $this->artisan('import:sftp')->assertExitCode(0);
    }

    /** @test */
    public function importFromSftFailedTest()
    {
        $adapter = $this->createMock(SftpService::class);
        $adapter->method('saveFile')
            ->willThrowException(new Exception('Failed As Expected'));
        $this->app->instance(SftpService::class,$adapter);
        $this->artisan('import:sftp')->assertExitCode(1);
    }

}
