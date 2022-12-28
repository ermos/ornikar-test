<?php

namespace App\Entity;

use App\Core\Entity;

class Learner extends Entity
{
    public function __construct(
        public readonly int $id,
        public readonly string $firstname,
        public readonly string $lastname,
        public readonly string $email,
    ) {
    }
}
