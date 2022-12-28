<?php
namespace App\Service\TemplateManager\Error;

use Throwable;

class KeyNotFoundError extends \Exception
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct("key not found", 800, $previous);
    }
}