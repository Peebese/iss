<?php
/**
 * Created by PhpStorm.
 * User: philipbrown
 * Date: 13/12/2018
 * Time: 22:56
 */
namespace PhilipBrown\Avanti\ApiClient;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use PhilipBrown\Avanti\config\config;

class ApiClientService {

    private $httpClient;
    private $config;

    public function __construct(
        ClientInterface $client,
        Config $config
    )
    {
       $this->httpClient    = $client;
       $this->config        = $config;
    }

    public function retrieveData()
    {
        $request = new Request(
            'GET',
            env('ISS_API_DOMAIN').'/satellites',
            [
                'Content-Type' => 'application/json',
                'x-torpedoes' => '2',
            ]
        );

        $response = $this->httpClient->send($request);
        $response->getBody()->rewind();

        return $response->getBody()->getContents();
    }
}