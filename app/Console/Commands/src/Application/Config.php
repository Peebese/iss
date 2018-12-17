<?php

namespace App\Console\Commands\src\Application;


class Config
{
    /**
     * Application config file location
     */
    private const CONFIG_FILE = __DIR__.'/../../config/config.php';

    /**
     * @var config array
     */
    private $config;

    /**
     * @return array
     * @throws \Exception
     */
    private function getConfigData() : array
    {
        if(!$this->config){

            if(!file_exists(static::CONFIG_FILE)) {

                throw new \Exception('Cannot find '. static::CONFIG_FILE . ' file, run Composer Install');
            }

            $this->config = include static::CONFIG_FILE;
        }

        return $this->config;
    }

    public function getApiDomain() : string
    {
        return $this->getConfigData()['api_domain'];
    }
}