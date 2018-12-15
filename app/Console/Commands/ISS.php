<?php


namespace App\Console\Commands;

use PhilipBrown\Avanti\ApiClient\ApiClientService;
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
        $apiClient = new ApiClientService();
        $data = $apiClient->retrieveData();
        $this->info($data);
    }


}