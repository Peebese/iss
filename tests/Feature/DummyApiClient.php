<?php


namespace Tests\Feature;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class DummyApiClient extends Client
{
    /** @var ResponseInterface[] */
    private $response;

    /** @var RequestInterface[] */
    private $request = [];

    public function getSatellites()
    {
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            '[
                {
                    "name": "iss",
                    "id": 25544
                }
             ]'
        );
    }

    public function getSatelliteData()
    {
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            '{
                "name": "iss",
                "id": 25544,
                "latitude": 50.11496269845,
                "longitude": 118.07900427317,
                "altitude": 408.05526028199,
                "velocity": 27635.971970874,
                "visibility": "daylight",
                "footprint": 4446.1877699772,
                "timestamp": 1364069476,
                "daynum": 2456375.3411574,
                "solar_lat": 1.3327003598631,
                "solar_lon": 238.78610691196,
                "units": "kilometers"
             }'
        );
    }
}