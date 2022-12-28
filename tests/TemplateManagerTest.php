<?php

namespace Test;


use App\Context\ApplicationContext;
use App\Entity\Instructor;
use App\Entity\Learner;
use App\Entity\Lesson;
use App\Entity\MeetingPoint;
use App\Entity\Template;
use App\Repository\InstructorRepository;
use App\Repository\LessonRepository;
use App\Repository\MeetingPointRepository;
use App\TemplateManager;
use PHPUnit\Framework\TestCase;

class TemplateManagerTest extends TestCase
{
    public function setUp(): void
    {
        InstructorRepository::getInstance()->save(new Instructor(1, "jean", "rock"));
        MeetingPointRepository::getInstance()->save(new MeetingPoint(1, "http://lambda.to", "paris 5eme"));
        ApplicationContext::getInstance()->setCurrentUser(new Learner(1, "toto", "bob", "toto@bob.to"));
    }

    public function test(): void
    {
        $startAt = new \DateTime("2021-01-01 12:00:00");
        $endAt = (clone $startAt)->add(new \DateInterval('PT1H'));

        $lesson = new Lesson(1, 1 , 1, $startAt, $endAt);
        LessonRepository::getInstance()->save($lesson);

        $template = new Template(
            1,
            'Votre leçon de conduite avec [lesson:instructor_name]',
            "
Bonjour [user:first_name],

La reservation du [lesson:start_date] de [lesson:start_time] à [lesson:end_time] avec [lesson:instructor_name] a bien été prise en compte!
Voici votre point de rendez-vous: [lesson:meeting_point].

Bien cordialement,

L'équipe Ornikar
");
        $templateManager = new TemplateManager();

        $message = $templateManager->getTemplateComputed(
            $template,
            [
                'lesson' => $lesson
            ]
        );

        self::assertEquals('Votre leçon de conduite avec jean', $message->subject);
        self::assertEquals("
Bonjour Toto,

La reservation du 01/01/2021 de 12:00 à 13:00 avec jean a bien été prise en compte!
Voici votre point de rendez-vous: paris 5eme.

Bien cordialement,

L'équipe Ornikar
", $message->content);
    }
}
