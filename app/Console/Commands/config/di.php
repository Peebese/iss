<?php


use DI\Container;
use GuzzleHttp\Client;
use PhilipBrown\Avanti\ApiClient\ApiClientService;
use PhilipBrown\Avanti\config\config;

return [
    'api-client-service' => function (Container $container) {

        $httpClient = $container->get('http-client');
        $config = new Config();

        return new ApiClientService($httpClient, $config);
    },

    'http-client' => function () {
        return new Client();
    }
];