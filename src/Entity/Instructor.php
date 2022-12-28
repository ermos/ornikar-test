<?php

namespace App\Entity;

use App\Core\Entity;

/**
 * @property-read string $instructor_link
 */
class Instructor extends Entity
{
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
