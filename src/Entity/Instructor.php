<?php

namespace App\Entity;

use App\Cast\CapitalizeCast;
use App\Core\Entity;

/**
 * @property-read string $instructor_link
 */
class Instructor extends Entity
{
    protected array $cast = [
        "firstname" => CapitalizeCast::class,
        "lastname" => CapitalizeCast::class
    ];

    public function __construct(
        public readonly int $id,
        public readonly string $firstname,
        public readonly string $lastname,
    ) {
    }

    public function getInstructorLinkAttribute(): string
    {
        return sprintf("instructors/%d-%s", $this->id, urlencode($this->firstname));
    }
}
