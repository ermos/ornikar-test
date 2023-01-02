<?php

namespace App\Cast;

use App\Core\CastInterface;

class DateCast implements CastInterface
{

    /**
     * @throws CastInvalidTypeError
     */
    public function cast(mixed $value): string
    {
        if (!is_a($value, \DateTime::class)) {
            throw new CastInvalidTypeError("DateTime");
        }
        return $value->format('d/m/Y');
    }
}