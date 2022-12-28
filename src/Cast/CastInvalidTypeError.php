<?php
namespace App\Cast;

use Throwable;

class CastInvalidTypeError extends \Exception
{
    public function __construct(string $type, ?Throwable $previous = null)
    {
        parent::__construct(sprintf("invalid type, must be %s", $type), 600, $previous);
    }
}