<?php

namespace App\Entity;

use DateTime;

class Lesson
{
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
}
