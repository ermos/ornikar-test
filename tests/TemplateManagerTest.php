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
use App\Service\TemplateManager\Error\KeyNotFoundError;
use App\Service\TemplateManager\TemplateManager;
use PHPUnit\Framework\TestCase;

class TemplateManagerTest extends TestCase
{
    protected \DateTime $start_at;
    protected \DateTime $end_at;
    protected TemplateManager $template_manager;

    public function setUp(): void
    {
        $this->template_manager = new TemplateManager();

        InstructorRepository::getInstance()->save(
            new Instructor(1, "jean", "rock")
        );

        MeetingPointRepository::getInstance()->save(
            new MeetingPoint(1, "http://lambda.to", "paris 5eme")
        );

        ApplicationContext::getInstance()->setCurrentUser(
            new Learner(1, "toto", "bob", "toto@bob.to")
        );

        $this->start_at = new \DateTime("2021-01-01 12:00:00");
        $this->end_at = (clone $this->start_at)->add(new \DateInterval("PT1H"));

        LessonRepository::getInstance()->save(
            new Lesson(1, 1 , 1, $this->start_at, $this->end_at)
        );
    }

    // Test subject OK
    public function testSubjectOK(): void
    {
        $lesson = LessonRepository::getInstance()->getById(1);

        $template = new Template(1, "Your lesson ID is {{lesson.id}}", "Content");

        $message = $this->template_manager->parseTemplate($template, [
                "lesson" => $lesson
        ]);

        self::assertEquals("Your lesson ID is 1", $message->getContent());
    }

    // Test content OK
    public function testContentOK(): void
    {
        $lesson = LessonRepository::getInstance()->getById(1);

        $template = new Template(1, "Subject", "Your lesson ID is {{lesson.id}}");

        $message = $this->template_manager->parseTemplate($template, [
            "lesson" => $lesson
        ]);

        self::assertEquals("Your lesson ID is 1", $message->getContent());
    }

    // Test dynamic key mapping OK
    public function testDynamicKeyMappingOK(): void
    {
        $template = new Template(1, "Subject", "User first name is {{user.first_name}}");

        $message = $this->template_manager->parseTemplate($template, [
            "user" => [
                "first_name" => "Tata"
            ]
        ]);

        self::assertEquals("User first name is Tata", $message->getContent());
    }

    // Test dynamic nested key
    public function testDynamicNestedKeyOK(): void
    {
        $template = new Template(1, "Subject", "User first name is {{user.info.first_name}}");

        $message = $this->template_manager->parseTemplate($template, [
            "user" => [
                "info" => [
                    "first_name" => "Tata"
                ]
            ]
        ]);

        self::assertEquals("User first name is Tata", $message->getContent());
    }

    // Test without key
    public function testWithoutKeyOK(): void
    {
        $template = new Template(1, "Subject", "User first name is Tata");

        $message = $this->template_manager->parseTemplate($template);

        self::assertEquals("User first name is Tata", $message->getContent());
    }

    // Test with deprecated getTemplateComputed method
    public function testWithDeprecatedGetTemplateComputedMethodOK(): void
    {
        $template = new Template(1, "Subject", "User first name is Tata");

        $message = $this->template_manager->getTemplateComputed($template);

        self::assertEquals("User first name is Tata", $message->getContent());
    }

    // Test err if one key not found
    public function testErrIfOneKeyNotFound(): void
    {
        $template = new Template(1, "Subject", "User first name is {{user.last_name}}");

        $this->template_manager->parseTemplate($template, [
            "user" => [
                "first_name" => "Tata"
            ]
        ]);

        self::expectException(KeyNotFoundError::class);
    }


    /**
     * @todo a remove
     * @return void
     */
    public function testOldSystem(): void
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

        $message = $templateManager->parseTemplate(
            $template,
            [
                'lesson' => $lesson
            ]
        );

        self::assertEquals('Votre leçon de conduite avec jean', $message->getSubject());
        self::assertEquals("
Bonjour Toto,

La reservation du 01/01/2021 de 12:00 à 13:00 avec jean a bien été prise en compte!
Voici votre point de rendez-vous: paris 5eme.

Bien cordialement,

L'équipe Ornikar
", $message->getContent());
    }
}
