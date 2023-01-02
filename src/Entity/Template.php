<?php

namespace App\Entity;

use App\Core\Entity;

class Template extends Entity
{
    public function __construct(
        public readonly int $id,
        public string $subject,
        public string $content,
    ) { }

    /**
     * Set template subject
     * @param string $subject
     * @return $this
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Get template subject
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * Set template content
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get template content
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}
