<?php
/**
 * Created by PhpStorm.
 * User: PhilipB
 * Date: 2018-12-16
 * Time: 23:48
 */

namespace App\Console\Commands\src\Response;

use Throwable;

class InvalidMessageException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function fromResponseBody(string $responseBody): InvalidMessageException
    {
        return new static('Expected JSON with "id" field, but got: ' . var_export($responseBody, true));
    }
}