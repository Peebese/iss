<?php

namespace App\Console\Commands\src\Response;

use App\Console\Commands\src\ApiClient\ApiClientService;
use App\Console\Commands\src\Calculate\CalculateDistanceService;

class DataResponse implements DataResponseInterface
{
    /**
     * @var ApiClientService
     */
    private $satelliteData;

    public function __construct(ApiClientService $satData)
    {
        $this->satelliteData = $satData;
    }

    /**
     * Validates data has id
     *
     * @param string $inputData
     * @throws InvalidMessageException
     */
    public static function validate(string $inputData)
    {
        $jsonDataArr = self::fromJsonString($inputData);

        if ( !isset($jsonDataArr->id) || !isset($jsonDataArr->name)) {
            throw InvalidMessageException::fromResponseBody($inputData);
        }
    }

    /**
     * @param string $json
     * @return mixed
     */
    public static function fromJsonString(string $json)
    {
        return json_decode($json);
    }

    public static function getSatellitePosition(string $satData) : string
    {
        self::validate($satData);

        $satDataArr = self::fromJsonString($satData);

        $positionDataArr = [
            'id'        => $satDataArr->id,
            'name'      => $satDataArr->name,
            'latitude'  => $satDataArr->latitude,
            'longitude' => $satDataArr->longitude
        ];

        return json_encode($positionDataArr);
    }

    public static function retrieveFirstSatelliteId(Array $satArr) : int
    {
        $id = 0;
        foreach ($satArr as $satellite) {
            $id =  $satellite->id;
            break;
        }

        return $id;
    }

    public function getDistFromFirstSat(string $lat, string $long) : string
    {
        $firstSatData = $this->satelliteData->getFirstSatelliteData();
        $firstSatPosition = self::getSatellitePosition($firstSatData);
        $satLat = json_decode($firstSatPosition,true)['latitude'];
        $satLong = json_decode($firstSatPosition,true)['longitude'];

        return CalculateDistanceService::distance(
            $satLat,
            $satLong,
            $lat,
            $long);
    }

    public static function prepareDistanceResponse($distanceVal)
    {
        $responseArr = [
            'units' => 'km',
            'distance' => $distanceVal
        ];
        return json_encode($responseArr);
    }
}