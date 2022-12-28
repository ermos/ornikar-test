<?php
namespace App\Service\TemplateManager;

use App\Context\ApplicationContext;
use App\Core\Entity;
use App\Core\EntityInterface;
use App\Entity\Instructor;
use App\Entity\Learner;
use App\Entity\Lesson;
use App\Entity\Template;
use App\Repository\InstructorRepository;
use App\Repository\LessonRepository;
use App\Repository\MeetingPointRepository;
use App\Service\TemplateManager\Error\KeyNotFoundError;

class TemplateManager
{
    /**
     * Allows to parse and inject data inside template
     * @param Template $tpl
     * @param array $data
     * @return Template
     */
    public function parseTemplate(Template $tpl, array $data = []): Template
    {
        return clone($tpl)
            ->setSubject($this->computeText($tpl->getSubject(), $data))
            ->setContent($this->computeText($tpl->getContent(), $data));
    }

    /**
     * Allows to parse and inject data inside template
     * @deprecated use parseTemplate instead of this method
     * @param Template $tpl
     * @param array $data
     * @return Template
     */
    public function getTemplateComputed(Template $tpl, array $data = []): Template
    {
        return $this->parseTemplate($tpl, $data);
    }

    /**
     * @throws KeyNotFoundError
     */
    private function computeText(string $text, array $data): string
    {
        $matches = [];
        preg_match_all("/\{\{([a-zA-Z_.]+?)\:([a-zA-Z_]+?)\}\}/m", $text, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $object = $this->walk($data, explode(".", $match[1]));
            $key = $match[2];

            $result = is_a($object, Entity::class) ? $object->toCast($key) : ($object[$key] ?? null);
            if (!$result) {
                throw new KeyNotFoundError();
            }

            $text = str_replace($match[0], $result, $text);
        }

        return $text;
    }

    private function walk(EntityInterface|array $object, array $next = []): EntityInterface|array
    {
        if (!empty($next)) {
            $key = $next[0];
            $result = (is_array($object) ? $object[$next[0]] : $object->$key) ?? null;
            array_shift($next);
            return $this->walk($result, $next);
        }
        return $object;
    }
}
