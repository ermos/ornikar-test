<?php

namespace App\Entity;

class MeetingPoint
{
    public function __construct(
        public readonly int $id,
        public readonly string $url,
        public readonly string $name,
    ) {
    }
}
