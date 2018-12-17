<?php

namespace App\Console\Commands\src\ApiClient;

use App\Console\Commands\src\Calculate\CalculateDistanceService;
use App\Console\Commands\src\Response\DataResponse;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use App\Console\Commands\src\Application\Config;

class ApiClientService {

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var CalculateDistanceService
     */
    private $calculate;

    public function __construct(
        ClientInterface $client,
        Config $config,
        CalculateDistanceService $calculateService
    )
    {
       $this->httpClient    = $client;
       $this->config        = $config;
       $this->calculate     = $calculateService;
    }

    private function retrieveSatellitesData() : string
    {
        $request = new Request(
            'GET',
            $this->config->getApiDomain().'/satellites/',
            [
                'Content-Type' => 'application/json'
            ]
        );

        $response = $this->httpClient->send($request);
        $response->getBody()->rewind();

        return $response->getBody()->getContents();
    }

    private function retrieveSatelliteDataById(int $id) : string
    {
        $request = new Request(
            'GET',
            $this->config->getApiDomain().'/satellites/'.$id,
            [
                'Content-Type' => 'application/json'
            ]
        );

        $response = $this->httpClient->send($request);
        $response->getBody()->rewind();

        return $response->getBody()->getContents();
    }

    public function getFirstSatelliteData() : string
    {
        $allSatData = $this->retrieveSatellitesData();
        $allSatDataArr = DataResponse::fromJsonString($allSatData);
        $satId = DataResponse::retrieveFirstSatelliteId($allSatDataArr);
        return $this->retrieveSatelliteDataById($satId);
    }
}