<?php

use App\Console\Commands\src\Calculate\CalculateDistanceService;
use App\Console\Commands\src\Response\DataResponse;
use DI\Container;
use GuzzleHttp\Client;
use App\Console\Commands\src\ApiClient\ApiClientService;
use App\Console\Commands\src\Application\Config;

return [
    'api-client-service' => function (Container $container) {

        $httpClient = $container->get('http-client');
        $calculate  = $container->get('calculate-distance-service');
        $config     = new Config();

        return new ApiClientService($httpClient, $config, $calculate);
    },

    'http-client' => function () {
        return new Client();
    },

    'calculate-distance-service' => function () {
        return new CalculateDistanceService();
    },

    'data-response-service' => function (Container $container) {

        $apiClientService = $container->get('api-client-service');
        return new DataResponse($apiClientService);
    }
];