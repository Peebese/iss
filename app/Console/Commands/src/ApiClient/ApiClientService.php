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

    private function retrieveData(string $query = '') : string
    {
        $request = new Request(
            'GET',
            $this->config->getApiDomain().'/satellites/'.$query,
            [
                'Content-Type' => 'application/json'
            ]
        );

        $response = $this->httpClient->send($request);
        $response->getBody()->rewind();

        return $response->getBody()->getContents();
    }

    private function getSatellites() : string
    {
        return $this->retrieveData();
    }

    public function getSatelliteData() : array
    {
        $satelliteData = $this->getSatellites();

        $combineSatelliteData = function($satellite) {

            DataResponse::validateId($satellite);
            return DataResponse::fromJsonString($this->retrieveData($satellite->id));
        };

        return array_map($combineSatelliteData, DataResponse::fromJsonString($satelliteData));
    }
}