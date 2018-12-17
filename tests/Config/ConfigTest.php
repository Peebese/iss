<?php
namespace Tests\Config;

use App\Console\Commands\src\Application\Config;
use Tests\TestCase;

class ConfigTest extends TestCase
{
    public function testAppConfig()
    {
        $configFile = __DIR__.'/../../app/Console/Commands/config/config.php';
        $configOptions = include $configFile;

        $this->assertTrue(file_exists($configFile),'Cannot find config file, should have been created during composer install, here: '.$configFile);
        $this->assertTrue(gettype($configOptions) === 'array');

        $config = new Config();
        $this->assertTrue(gettype($config->getApiDomain()) === 'string');
    }
}