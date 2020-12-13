<?php


namespace App\MrCs\Services\Export\External;


use App\MrCs\Services\Export\External\Abstracts\ExportToExternalApiAbstract;
use Illuminate\Support\Facades\Log;

class ExportToExampleService extends ExportToExternalApiAbstract
{
    /**
     * ExportToExampleService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->base_url= config('exporttoexternal.example.url');
        $this->bearer_token =  config('exporttoexternal.example.bearer_token');
        $this->headers = [
            'Authorization' => 'Bearer ' . $this->bearer_token,
            'Accept'        => 'application/json',
        ];
    }

    /**
     * @param $data
     * @return false|mixed
     */
    public function export($data)
    {
        try {
            $response = $this->buildRequest($this->base_url,'POST',$this->headers,$data);
        }
        catch (\Exception $exception){
            Log::channel('external_export')->info('Error in exporting data : '.get_class().$exception->getMessage());
            return false;
        }
        Log::channel('external_export')->info('Export Success');
        return $response;
    }

}
