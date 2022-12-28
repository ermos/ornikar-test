<?php

namespace App\Entity;

class Template
{
    public function __construct(
        public readonly int $id,
        public string $subject,
        public string $content,
    ) {
    }
}
