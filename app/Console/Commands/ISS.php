<?php

namespace App\Console\Commands;

use App\Console\Commands\src\Application\ContainerBuilder;
use App\Console\Commands\src\Response\DataResponse;
use Illuminate\Console\Command;

class ISS extends Command
{
    /**
     * Console Command
     *
     * @var string
     */
    protected $signature = 'ISS:locate';

    /**
     * Execute console command
     */
    public function handle()
    {
        $container = (new ContainerBuilder())->buildContainer();
        $apiClient = $container->get('api-client-service');
        $response = $container->get('data-response-service');
        $data = $apiClient->getFirstSatelliteData();
        $distance = $response->getDistFromFirstSat('28.978917744091', '128.71059302811');

        $this->info(DataResponse::getSatellitePosition($data));
        $this->info(DataResponse::prepareDistanceResponse($distance));
    }
}