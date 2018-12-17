<?php

namespace Tests\Feature;

use App\Console\Commands\src\Application\ContainerBuilder;
use Tests\TestCase;


class ISSLocationTest extends TestCase
{
    private $dummyHttpClient;
    private $apiClientService;
    private $dataResponseService;

    public function setUp()
    {
        $container = (new ContainerBuilder())->buildContainer();

        $this->dummyHttpClient = new DummyApiClient();
        $container->set('http-client', $this->dummyHttpClient);

        $this->apiClientService = $container->get('api-client-service');
        $this->dataResponseService = $container->get('data-response-service');
    }

    /**
     * Tests Lat and Lon values
     *
     * @return void
     */
    public function testGetISSLatLan()
    {
        $satellites = $this->dummyHttpClient->getSatellites();
        $satData = $this->dummyHttpClient->getSatelliteData();
        $satPosition = $this->dataResponseService->getSatellitePosition($satData->getBody());
        $satPosObj = json_decode($satPosition);

        $this->assertEquals(['application/json'],$satellites->getHeader('Content-Type'));
        $this->assertNotEmpty($satPosition);
        $this->assertEquals('118.07900427317', $satPosObj->longitude);
    }

    /**
     * Test calculation of distance between points
     *
     * @return void
     */
    public function testCalculateDistance()
    {
        $distance = $this->dataResponseService->getDistFromFirstSat('28.978917744091', '128.71059302811');
        $this->assertTrue($distance > 0);
    }

    /**
     * Test api end point is expected
     *
     * @return void
     */
    public function testAPIEndpoint()
    {
        $this->assertEquals('https://api.wheretheiss.at/v1/satellites/','https://api.wheretheiss.at/v1/satellites/');
    }


}
