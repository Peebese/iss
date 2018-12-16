<?php

use DI\Container;
use GuzzleHttp\Client;
use App\Console\Commands\src\ApiClient\ApiClientService;
use App\Console\Commands\src\Application\Config;

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