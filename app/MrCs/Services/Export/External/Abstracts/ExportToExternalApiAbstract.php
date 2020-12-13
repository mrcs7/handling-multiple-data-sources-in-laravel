<?php


namespace App\MrCs\Services\Export\External\Abstracts;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

abstract class ExportToExternalApiAbstract
{
    /**
     * @var
     */
    protected $base_url;
    /**
     * @var
     */
    public $request_client;
    /**
     * @var
     */
    protected $headers;

    /**
     * ExportToExternalApiAbstract constructor.
     */
    public function __construct()
    {
        if(!$this->request_client) {
            $this->setClient(new Client());
        }
    }

    /**
     * @param $client
     */
    public function setClient($client)
    {
        $this->request_client = $client;
    }

    /**
     * @param $uri
     * @param $method
     * @param $headers
     * @param array $body
     * @return mixed
     */
    final protected function buildRequest($uri, $method, $headers,$body = [])
    {
        $request = new Request($method, $this->base_url . $uri, $headers);
        $response = $this->request_client->send($request, [$body]);
        return json_decode($response->getBody());
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->request_client;
    }

    /**
     * @param $data
     * @return mixed
     */
    abstract function export($data);

}
