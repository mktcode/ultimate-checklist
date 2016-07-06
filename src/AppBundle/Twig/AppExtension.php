<?php

namespace AppBundle\Twig;

use AppBundle\Entity\CheckInstance;
use AppBundle\Entity\CheckInstanceCheck;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->em = $this->container->get('doctrine.orm.entity_manager');
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('isChecked', [$this, 'isCheckedFilter']),
            new \Twig_SimpleFilter('checkedBy', [$this, 'checkedByFilter']),
            new \Twig_SimpleFilter('checkedDate', [$this, 'checkedDateFilter']),
            new \Twig_SimpleFilter('checkProgress', [$this, 'checkProgressFilter']),
            new \Twig_SimpleFilter('points', [$this, 'pointsFilter']),
        ];
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

    public function checkProgressFilter(CheckInstance $checkInstance)
    {
        $checked = 0;
        foreach ($checkInstance->getChecklist()->getTasks() as $task) {
            $check = $this->em->getRepository('AppBundle:CheckInstanceCheck')->findOneBy([
                'task' => $task,
                'checkInstance' => $checkInstance
            ]);

            $checked += $check ? (int) $check->isChecked() : 0;
        }

        return round($checked / $checkInstance->getChecklist()->getTasks()->count() * 100);
    }

    public function pointsFilter(User $user)
    {
        $points = 0;
        $pointsInit = $this->container->getParameter('points.init');
        $pointsCheck = $this->container->getParameter('points.check');

        $checks = $user->getCheckInstanceChecks();
        foreach ($checks as $check) {
            $points += $check->isChecked() ? $pointsCheck : 0;
        }

        $checkInstances = $user->getCheckInstances();
        foreach ($checkInstances as $checkInstance) {
            $points += $this->checkProgressFilter($checkInstance) == 100 ? $pointsInit : 0;
        }

        return $points;
    }

    public function getName()
    {
        return 'app_extension';
    }
}