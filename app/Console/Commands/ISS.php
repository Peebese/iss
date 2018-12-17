<?php


namespace App\Console\Commands;

use App\Console\Commands\src\Application\ContainerBuilder;
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
        $data = $apiClient->getSatelliteData();

        $distance = $response->getSatelliteDistance('28.978917744091', '128.71059302811');

        $this->info(print_r($response->getSatellitePosition($data), true));
        $this->info(print_r($distance, true));
    }
}