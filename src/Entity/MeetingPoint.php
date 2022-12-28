<?php

namespace App\Entity;

use App\Core\Entity;

class MeetingPoint extends Entity
{
    public function __construct(
        public readonly int $id,
        public readonly string $url,
        public readonly string $name,
    ) {
    }
}
