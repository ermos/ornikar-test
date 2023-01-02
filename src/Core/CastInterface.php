<?php

namespace App\Core;

interface CastInterface
{
    public function cast(mixed $value): mixed;
}