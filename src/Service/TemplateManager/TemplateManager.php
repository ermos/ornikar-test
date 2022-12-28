<?php
namespace App\Service\TemplateManager;

use App\Context\ApplicationContext;
use App\Entity\Instructor;
use App\Entity\Learner;
use App\Entity\Lesson;
use App\Entity\Template;
use App\Repository\InstructorRepository;
use App\Repository\LessonRepository;
use App\Repository\MeetingPointRepository;

class TemplateManager
{
    /**
     * Allows to parse and inject data inside template
     * @param Template $tpl
     * @param array $data
     * @return Template
     */
    public function parseTemplate(Template $tpl, array $data = [])
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
    public function getTemplateComputed(Template $tpl, array $data = [])
    {
        return $this->parseTemplate($tpl, $data);
    }

    private function computeText(string $text, array $data): string
    {
        $lesson = (isset($data['lesson']) and $data['lesson'] instanceof Lesson) ? $data['lesson'] : null;

        if(strpos($text, '[lesson:start_date]') !== false)
            $text = str_replace('[lesson:start_date]', $lesson->startTime->format('d/m/Y'), $text);

        if(strpos($text, '[lesson:start_time]') !== false)
            $text = str_replace('[lesson:start_time]', $lesson->startTime->format('H:i'), $text);

        if(strpos($text, '[lesson:end_time]') !== false)
            $text = str_replace('[lesson:end_time]', $lesson->endTime->format('H:i'), $text);


            if (isset($data['instructor'])  and ($data['instructor']  instanceof Instructor))
                $text = str_replace('[instructor_link]',  'instructors/' . $data['instructor']->id .'-'.urlencode($data['instructor']->firstname), $text);
            else
                $text = str_replace('[instructor_link]', '', $text);

        /*
         * USER
         * [user:*]
         */
        $_user  = (isset($data['user'])  and ($data['user']  instanceof Learner))  ? $data['user']  : ApplicationContext::getCurrentUser();
        if($_user) {
            (strpos($text, '[user:first_name]') !== false) and $text = str_replace('[user:first_name]'       , ucfirst(strtolower($_user->firstname)), $text);
        }

        return $text;
    }
}
