<?php
/**
 * Created by PhpStorm.
 * User: PhilipB
 * Date: 2018-12-16
 * Time: 20:41
 */

namespace App\Console\Commands\src\Response;


use App\Console\Commands\src\ApiClient\ApiClientService;
use App\Console\Commands\src\Calculate\CalculateDistanceService;

class DataResponse
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
     * @param \stdClass $inputData
     * @throws InvalidMessageException
     */
    public static function validateId(\stdClass $inputData)
    {
        if ( !isset($inputData->id)) {
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

    public static function getSatellitePosition(array $satData) : array
    {
        $satelliteLatLong = function($satellite) {

            return [
                'id'        => $satellite->id,
                'name'      => $satellite->name,
                'latitude'  => $satellite->latitude,
                'longitude' => $satellite->longitude
            ];
        };

        return array_map($satelliteLatLong, $satData);
    }

    public function getSatelliteDistance(string $lat, string $long) : array
    {
        $satellitePostion = $this->satelliteData->getSatelliteData();
        $satelliteDistance = [];

        foreach ($satellitePostion as $satellite) {

            $satelliteDistance[] = CalculateDistanceService::distance(
                $satellite->latitude,
                $satellite->longitude,
                $lat,
                $long);
        }

        return $satelliteDistance;
    }
}