<?php

namespace AppBundle\Service;

use AppBundle\Entity\CheckInstance;
use AppBundle\Entity\CheckInstanceCheck;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Helper
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->em = $this->container->get('doctrine.orm.entity_manager');
    }

    /**
     * Returns a configuration parameter from parameters.yml.
     *
     * @param $key
     * @return mixed
     */
    public function getParameter($key)
    {
        return $this->container->getParameter($key);
    }

    /**
     * Checks if a task is checked in the given instance.
     *
     * @param Task $task
     * @param CheckInstance $checkInstance
     * @return bool
     */
    public function isTaskChecked(Task $task, CheckInstance $checkInstance)
    {
        /** @var CheckInstanceCheck $check */
        $check = $this->em->getRepository('AppBundle:CheckInstanceCheck')->findOneBy([
            'task' => $task,
            'checkInstance' => $checkInstance
        ]);

        return $check ? $check->isChecked() : false;
    }

    /**
     * Returns the user the task was checked by.
     *
     * @param Task $task
     * @param CheckInstance $checkInstance
     * @return string
     */
    public function getTaskCheckedBy(Task $task, CheckInstance $checkInstance)
    {
        /** @var CheckInstanceCheck $check */
        $check = $this->em->getRepository('AppBundle:CheckInstanceCheck')->findOneBy([
            'task' => $task,
            'checkInstance' => $checkInstance
        ]);

        return $check ? $check->getUser()->getUsername() : '';
    }

    /**
     * Returns the date and time the task was checked.
     *
     * @param Task $task
     * @param CheckInstance $checkInstance
     * @return string
     */
    public function getTaskCheckedDate(Task $task, CheckInstance $checkInstance)
    {
        /** @var CheckInstanceCheck $check */
        $check = $this->em->getRepository('AppBundle:CheckInstanceCheck')->findOneBy([
            'task' => $task,
            'checkInstance' => $checkInstance
        ]);

        return $check ? $check->getDate()->format('d.m.Y H:i') . ' Uhr' : '';
    }

    /**
     * Returns the note of a checked task.
     *
     * @param Task $task
     * @param CheckInstance $checkInstance
     * @return string
     */
    public function getTaskCheckedNote(Task $task, CheckInstance $checkInstance)
    {
        /** @var CheckInstanceCheck $check */
        $check = $this->em->getRepository('AppBundle:CheckInstanceCheck')->findOneBy([
            'task' => $task,
            'checkInstance' => $checkInstance
        ]);

        return $check ? $check->getNote() : '';
    }

    /**
     * Returns the percentage of checked tasks for the given instance.
     *
     * @param CheckInstance $checkInstance
     * @return float
     */
    public function getCheckInstanceProgress(CheckInstance $checkInstance)
    {
        $checked = 0;
        foreach ($checkInstance->getChecklist()->getTasks() as $task) {
            /** @var CheckInstanceCheck $check */
            $check = $this->em->getRepository('AppBundle:CheckInstanceCheck')->findOneBy([
                'task' => $task,
                'checkInstance' => $checkInstance
            ]);

            $checked += $check ? (int) $check->isChecked() : 0;
        }

        return round($checked / $checkInstance->getChecklist()->getTasks()->count() * 100);
    }

    /**
     * Returns a users points.
     *
     * @param User $user
     * @return int|mixed
     */
    public function getPointsForUser(User $user)
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
            $points += $this->getCheckInstanceProgress($checkInstance) == 100 ? $pointsInit : 0;
        }

        return $points;
    }
}