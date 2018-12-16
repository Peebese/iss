<?php
/**
 * Created by PhpStorm.
 * User: philipbrown
 * Date: 13/12/2018
 * Time: 22:56
 */
namespace App\Console\Commands\src\ApiClient;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use App\Console\Commands\src\Application\Config;

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

    private function retrieveData(string $query = '')
    {
        $request = new Request(
            'GET',
            $this->config->getApiDomain().'/satellites/'.$query,
            [
                'Content-Type' => 'application/json',
                'x-torpedoes' => '2',
            ]
        );

        $response = $this->httpClient->send($request);
        $response->getBody()->rewind();

        return $response->getBody()->getContents();
    }

    private function getSatilliteId() : array
    {
        return json_decode($this->retrieveData());
    }

    private function getSatelliteData() : array
    {
        $satelliteData = $this->getSatilliteId();

        $combineSatelliteData = function($satellite) {
            return json_decode($this->retrieveData($satellite->id));
        };

        return array_map($combineSatelliteData,$satelliteData);
    }

    public function getSatellitePosition() : array
    {
        $satelliteData = $this->getSatelliteData();
        $satelliteLatLong = function($satellite) {

          return [
              'latitude' => $satellite->latitude,
              'longitude' => $satellite->longitude
              ];
        };
        return array_map($satelliteLatLong, $satelliteData);
    }

    public function getSatelliteDistance(string $lat, string $long)
    {
        $satellitePostion = $this->getSatellitePosition();

        $satelliteDistance = [];

        foreach ($satellitePostion as $satellite) {
            $satelliteDistance[] = $this->distance($satellite['latitude'], $satellite['longitude'],$lat,$long, 'K');
        }

        return $satelliteDistance;

//       return array_map(function($satellite, $lat, $long){
//            return $this->distance($satellite->latitude, $satellite->longitude,$lat,$long, 'K');
//        },$satellitePostion);

    }

    public function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        }
        else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1))
                * sin(deg2rad($lat2)) +
                cos(deg2rad($lat1)) *
                cos(deg2rad($lat2)) *
                cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }
}