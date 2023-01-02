<?php

namespace App\Cast;

use App\Core\CastInterface;

class CapitalizeCast implements CastInterface
{

    /**
     * @throws CastInvalidTypeError
     */
    public function cast(mixed $value): string
    {
        if (!is_string($value)) {
            throw new CastInvalidTypeError("string");
        }
        return ucfirst(strtolower($value));
    }
}