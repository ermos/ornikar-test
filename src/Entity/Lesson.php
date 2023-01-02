<?php

namespace App\Entity;

use App\Cast\CastInvalidTypeError;
use App\Cast\DateCast;
use App\Cast\TimeCast;
use App\Core\Entity;
use DateTime;

/**
 * @property-read string $render_html
 * @property-read string $render_text
 * @property-read string $start_date
 */
class Lesson extends Entity
{
    protected array $cast = [
        "startTime" => TimeCast::class,
        "endTime" => TimeCast::class
    ];

    public function __construct(
        public readonly int $id,
        public readonly int $meetingPointId,
        public readonly int $instructorId,
        public readonly DateTime $startTime,
        public readonly DateTime $endTime,
    ) {
    }

    public static function renderHtml(Lesson $lesson): string
    {
        return '<p>' . $lesson->id . '</p>';
    }

    public static function renderText(Lesson $lesson): string
    {
        return (string) $lesson->id;
    }

    /**
     * Get lesson to html format
     * @return string
     */
    public function getRenderHtmlAttribute(): string
    {
        return self::renderHtml($this);
    }

    /**
     * Get lesson to text format
     * @return string
     */
    public function getRenderTextAttribute(): string
    {
        return self::renderText($this);
    }

    /**
     * Get lesson start date
     * @return string
     * @throws CastInvalidTypeError
     */
    public function getStartDateAttribute(): string
    {
        return (new DateCast())->cast($this->startTime);
    }
}
