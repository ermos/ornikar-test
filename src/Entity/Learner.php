<?php

namespace App\Entity;

class Learner
{
    public function __construct(
        public readonly int $id,
        public readonly string $firstname,
        public readonly string $lastname,
        public readonly string $email,
    ) {
    }
}
