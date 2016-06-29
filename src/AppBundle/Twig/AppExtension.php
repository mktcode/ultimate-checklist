<?php

namespace AppBundle\Twig;

use AppBundle\Entity\CheckInstance;
use AppBundle\Entity\Task;
use Doctrine\ORM\EntityManager;

class AppExtension extends \Twig_Extension
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('isChecked', array($this, 'isCheckedFilter')),
            new \Twig_SimpleFilter('checkedBy', array($this, 'checkedByFilter')),
            new \Twig_SimpleFilter('checkedDate', array($this, 'checkedDateFilter')),
        );
    }

    public function isCheckedFilter(Task $task, CheckInstance $checkInstance)
    {
        $check = $this->em->getRepository('AppBundle:CheckInstanceCheck')->findOneBy([
            'task' => $task,
            'checkInstance' => $checkInstance
        ]);

        return $check ? $check->isChecked() : false;
    }

    public function checkedByFilter(Task $task, CheckInstance $checkInstance)
    {
        $check = $this->em->getRepository('AppBundle:CheckInstanceCheck')->findOneBy([
            'task' => $task,
            'checkInstance' => $checkInstance
        ]);

        return $check ? $check->getUser()->getUsername() : '';
    }

    public function checkedDateFilter(Task $task, CheckInstance $checkInstance)
    {
        $check = $this->em->getRepository('AppBundle:CheckInstanceCheck')->findOneBy([
            'task' => $task,
            'checkInstance' => $checkInstance
        ]);

        return $check ? $check->getDate()->format('d.m.Y H:i') . ' Uhr' : '';
    }

    public function getName()
    {
        return 'app_extension';
    }
}