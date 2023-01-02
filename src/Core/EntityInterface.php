<?php

namespace App\Core;

interface EntityInterface
{
    public function __get(string $name): mixed;

    /**
     * Allows to cast field
     * @param string $field
     * @return string
     */
    public function toCast(string $field): mixed;
}