<?php

namespace App\Core;

class Entity implements EntityInterface
{
    /**
     * Cast fields mapping
     * @var array
     */
    protected array $cast = [];

    /**
     * Manager computed fields
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        $method = sprintf(
            "get%sAttribute",
            str_replace("_", "", ucwords($name, "_"))
        );
        return method_exists($this, $method) ? $this->$method() : null;
    }

    public function toCast(string $field): mixed
    {
        if (!empty($this->cast[$field]) && class_exists($this->cast[$field])) {
            /** @var CastInterface $cast */
            $cast = new $this->cast[$field]();
            return $cast->cast($this->$field);
        }
        return $this->$field;
    }
}