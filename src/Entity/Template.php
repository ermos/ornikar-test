<?php

namespace App\Entity;

class Template
{
    public function __construct(
        protected readonly int $id,
        protected string $subject,
        protected string $content,
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
