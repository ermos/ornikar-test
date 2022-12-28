<?php

namespace App\Entity;

use App\Cast\CapitalizeCast;
use App\Core\Entity;

class Learner extends Entity
{
    protected array $cast = [
      "firstname" => CapitalizeCast::class,
      "lastname" => CapitalizeCast::class
    ];

    public function __construct(
        public readonly int $id,
        public readonly string $firstname,
        public readonly string $lastname,
        public readonly string $email,
    ) {
    }
}
