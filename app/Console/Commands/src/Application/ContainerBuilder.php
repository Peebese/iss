<?php


namespace App\Console\Commands\src\Application;

use DI\Container;


class ContainerBuilder
{
    public function buildContainer() : Container
    {
        $containerArray = include __DIR__ .'/../../config/di.php';
        $container = new Container();

        foreach($containerArray as $containerName => $containerVal) {

            $container->set($containerName, $containerVal);
        }

        return $container;
    }
}