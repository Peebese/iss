<?php
/**
 * Created by PhpStorm.
 * User: philipbrown
 * Date: 17/12/2018
 * Time: 22:24
 */

namespace App\Console\Commands\src\Response;


interface DataResponseInterface
{
    public static function validate(string $inputData);
}