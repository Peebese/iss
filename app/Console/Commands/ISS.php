<?php


namespace App\Console\Commands;

use App\Console\Commands\src\Application\ContainerBuilder;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

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
        $data = $apiClient->getSatellitePosition();
        $distance = $apiClient->getSatelliteDistance('28.978917744091', '128.71059302811');

        echo print_r($data, true);
        echo print_r($distance, true);
        //$this->info($data);
    }


}